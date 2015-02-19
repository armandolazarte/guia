<?php

namespace Guia\Classes\Pdfs;

use Carbon\Carbon;
use fpdf\FPDF;
use Guia\Models\Req;
use Guia\User;
use Illuminate\Database\Eloquent\Collection;

class Requisicion extends FPDF
{
    public $req;
    public $articulos;
    public $solicita;
    public $autoriza;
    public $vobo;
    public $nombre_revisa;

    public function __construct(Req $req, Collection $articulos)
    {
        $this->req = $req;
        $this->articulos = $articulos;
        $this->getUsuarios();
        parent::__construct('P','mm','Letter');
    }

    private function getUsuarios()
    {
        $this->solicita = User::find($this->req->solicita);
        $this->autoriza = User::find($this->req->autoriza);
        $this->vobo = User::find($this->req->vobo);
    }

    public function Header()
    {
        $this->SetFont('Arial','B',10);
        $this->Image(asset('img/membrete_req.jpg'),10,3,0,25);
        $this->SetXY(33,23);
        $this->MultiCell(55,5,'REQUISICION DE ARTICULOS DE SERVICIOS E INVENTARIO',0,'L');
        //$this->SetFont('Arial','',8);
        //$this->SetXY();
        //$this->Cell(20,5,'Hoja '.$this->PageNo().'de {nb}',0,1,'R');
        $this->SetFont('Arial','',9);
        $this->SetXY(-35,5);
        $this->Cell(30,5,'SOLICITUD','LTR',2,'C');
        $this->Cell(30,5,$this->req->req,'LTR',2,'C');
        $this->Cell(30,5,utf8_decode ('DIA / MES /AÑO'),'LTR',2,'C');
        $fecha = Carbon::parse($this->req->fecha_req)->format('d/m/Y');
        $this->Cell(30,5, $fecha,'LTBR',1,'C');
        $this->Ln(10);
    }

    public function Footer()
    {
        $this->SetFont('Arial','',8);
        $this->SetY(-20);
        //Jefe Unidad Adquisiciones
//        $info_suministros = Info_Directivos::info('ADQ', TRUE);
//        $this->MultiCell(55,4,utf8_decode ($info_suministros['nombre']),'T','C');
//        $this->MultiCell(55,4,'Jefe de la Unidad de Adquisiciones y Suministros',0,'C');

        //Sec. Administrativo
//        $info_sad = Info_Directivos::info('SAD', TRUE);
        //Excepción para Sec. Administrativo
//        if ( $this->solicita != $info_sad['usr'] )
//        {
//            $this->SetXY(67, -20);
//            $this->MultiCell(45,4,utf8_decode ($info_sad['nombre']),'T','C');
//            $this->SetX(67);
//            $this->MultiCell(45,4,'Secretario Administrativo',0,'C');
//            //AUTORIZA
//        }

        //Solicita
        $this->SetXY(-55, -20);
        $this->MultiCell(50,4,utf8_decode($this->solicita->nombre),'T','C');
        $this->SetX(-55);
        $this->MultiCell(50,4,utf8_decode($this->solicita->cargo),0,'C');

        //Dueño del proyecto
        if (!empty($this->autoriza)){
            $this->SetXY(114, -20);
            $this->MultiCell(45,4,utf8_decode($this->autoriza->nombre),'T','C');
            $this->SetX(114);
            $this->MultiCell(45,4,utf8_decode($this->autoriza->cargo),0,'C');
        }
        //Jefe del Departamento de adscripción del Laboratorio
        if (!empty($this->vobo)){
            $this->SetXY(-57, -40);
            $this->MultiCell(50,4,utf8_decode($this->vobo->nombre),'T','C');
            $this->SetX(-57);
            $this->MultiCell(50,4,utf8_decode($this->vobo->cargo),0,'C');
        }
    }

    public function  doIfLongCell() {
        $this->Line($this->GetX()-20, $this->GetY(), $this->GetX()-20, 53);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), 53);
        $this->Line($this->GetX()+120, $this->GetY(), $this->GetX()+120, 53);
        $this->Line($this->GetX()+150, $this->GetY(), $this->GetX()+150, 53);
        $this->Line($this->GetX()+180, $this->GetY(), $this->GetX()+180, 53);
    }

    public function crearPdf()
    {
        $this->AliasNbPages();
        $this->SetAutoPageBreak(true, 30);
        $this->AddPage();

        //Lugar de Entrega
        $this->SetFont('Arial','B',8);
        $this->Cell(200,5,'LUGAR EN QUE SE REQUIEREN LOS ARTICULOS','LTR',1,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(200,5,utf8_decode($this->req->lugar_entrega),'LTBR',1,'C');
        $this->Ln(3);

        //Articulos Capturados
        $this->SetFont('Arial','B',8);
        $this->Cell(20,5,'CODIGO','LTBR',0,'C');
        $this->Cell(120,5,'DESCRIPCION','TBR',0,'C');
        $this->Cell(30,5,'CANTIDAD','TBR',0,'C');
        $this->Cell(30,5,'OBSERVACION','TBR',1,'C');
        $y_linea = $this->GetY();

        $this->SetFont('Arial','',8);
        $no_pagina = $this->PageNo();

        //Iteraciones para Articutos
        foreach($this->articulos as $articulo)
        {
            $this->SetFont('Arial','',8);

            $this->SetX(30);
            //Se calcula cuantos renglones ocupará el artículo y su descripción
            $y_inicial = $this->GetY();
            $desc_articulo = iconv('UTF-8', 'windows-1252//TRANSLIT//IGNORE', $articulo->articulo);
            $this->isLongCell = true;
            $this->MultiCell(120,3,$desc_articulo,1,'L');
            $this->isLongCell = false;

            //Se reinicializa la y_inicial
            if ( $no_pagina != $this->PageNo() ) {
                $y_inicial = 35;
                $no_pagina = $this->PageNo();
            }

            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial; //Determina la altura del renglón

            $this->SetY($y_inicial);
            $this->Cell(20,$h_renglon,'','LBR',0,'C');
            $this->SetXY(150,$y_inicial);
            $this->Cell(30,$h_renglon, $articulo->cantidad.' '.utf8_decode($articulo->unidad),'LBR',0,'C');
            $this->Cell(30,$h_renglon,'','LBR',1,'C');
        }

        //Dibuja lineas cuando termina iteración
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), 230);
        $this->Line($this->GetX() + 20, $this->GetY(), $this->GetX() + 20, 230);
        $this->Line($this->GetX() + 140, $this->GetY(), $this->GetX() + 140, 230);
        $this->Line($this->GetX() + 170, $this->GetY(), $this->GetX() + 170, 230);
        $this->Line($this->GetX() + 200, $this->GetY(), $this->GetX() + 200, 230);
        $this->Line($this->GetX(), 230, 210, 230);

        //Información Presupuestal
        $this->SetY(232);
        $this->Line($this->GetX(), $this->GetY(), 210, $this->GetY());//Linea superior
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), $this->GetY() + 16);//Linea izquierda
        $this->Line(210, $this->GetY(), 210, $this->GetY() + 16);//Linea derecha
        $this->SetFont('Arial','',8);
        $this->Cell(30,4,'Proyecto: '.$this->req->proyecto->proyecto, 0, 1, 'L');

        //$this->Cell(30,4,'Fondo: '.$this->req->proyecto->fondos, 0, 1, 'L');

        //Observaciones
        $this->SetXY(40,234);
        !empty($this->nombre_revisa) ? $width_obs = 120 :$width_obs = 170;
        $this->MultiCell($width_obs,2.5,utf8_decode($this->req->obs),0,'L');
        $this->SetY(248);
        $this->Line($this->GetX(), $this->GetY(), 210, $this->GetY());//Linea inferior

        $this->Output('Req'.$this->req->req,'I');
    }
}
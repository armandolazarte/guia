<?php

namespace Guia\Classes\Pdfs;

use fpdf\FPDF;
use Carbon\Carbon;
use Guia\Models\Cotizacion;

class InvitacionPdf extends FPDF {

    public $invitacion;
    public $usuario_adq;
    public $articulos;

    public function __construct(Cotizacion $invitacion, $articulos)
    {
        $this->invitacion = $invitacion;
        $this->usuario_adq = \InfoDirectivos::getResponsable('ADQ');
        $this->articulos = $articulos;

        parent::__construct('P','mm','Letter');
    }

    public function Header()
    {
        !empty($this->invitacion->benef->contacto) ? $contacto = $this->invitacion->benef->contacto : $contacto = '';

        $this->Image(asset('img/membrete_req.jpg'),10,3,0,25);
//        $this->Cell(20,5,'Hoja '.$this->PageNo().'de {nb}',0,1,'R');//Deshabilitado debido a que causa un error al generar PDF
        $this->SetXY(10,30);
        $this->SetFont('Arial','B',8);
        $this->Cell(30,4,'PROVEEDOR:',0,1,'L');
        $this->Cell(30,4,'AT\'N:',0,1,'L');
        $this->Cell(30,4,'TELEFONO:',0,1,'L');
        $this->SetXY(40,30);
        $this->SetFont('Arial','',8);
        $this->Cell(170,4,utf8_decode($this->invitacion->benef->benef),0,2,'L');
        $this->Cell(170,4,utf8_decode($contacto),0,2,'L');
        $this->Cell(170,4,utf8_decode($this->invitacion->benef->tel),0,1,'L');
        $this->Ln(2);
        $this->Cell(200,4,utf8_decode ('Por medio de la Presente y de la manera mas atenta solicitamos a usted cotizar el material que a continuación señalamos:'),0,1,'L');

        $sub_head_y = $this->GetY();
        $this->SetFont('Arial','B',8);
        $this->Cell(30,4,'DEPENDENCIA:',0,1,'L');
        $this->Cell(30,4,'PROYECTO:',0,1,'L');
        $this->Cell(35,4,'LUGAR DE ENTREGA:',0,1,'L');
        $this->SetXY(-60,$sub_head_y);
        $this->Cell(30,4,'REQUISICION No.:',0,2,'L');
        $this->Cell(30,4,'FECHA INVITACION: ',0,2,'L');

        $this->SetFont('Arial','',8);
        $this->SetXY(45,$sub_head_y);
        $this->Cell(100,4,utf8_decode($this->invitacion->req->urg->urg.' '.$this->invitacion->req->urg->d_urg),0,2,'L');
        $this->Cell(100,4,$this->invitacion->req->proyecto->proyecto.' '.$this->invitacion->req->proyecto->d_proyecto,0,1,'L');
        $this->SetXY(45,$sub_head_y+8);
        $this->Cell(165,4,utf8_decode($this->invitacion->req->lugar_entrega),0,2,'L');
        $this->SetXY(-30,$sub_head_y);
        $this->Cell(20,4,$this->invitacion->req->req,0,2,'L');
        $this->Cell(20,4,Carbon::parse($this->invitacion->fecha_invitacion)->format('d/m/Y'),0,1,'L');
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetFont('Arial','',8);
        $this->SetXY(80,-20);
        $this->MultiCell(60,4,utf8_decode($this->usuario_adq->nombre),'T','C');
        $this->SetX(80);
        $this->MultiCell(60,4,utf8_decode($this->usuario_adq->cargo),0,'C');
        $this->SetY(-10);

        $this->Cell(50,4,'Solicita: '.utf8_decode($this->invitacion->req->user->nombre),0,'L');
        $this->Ln();
        $this->Cell(50,4,'Correo: '.$this->invitacion->req->user->email,0,'L');
    }

    public function crearPdf()
    {
        $this->AliasNbPages();
        $this->AddPage();

        //Articulos Capturados
        $this->SetFont('Arial','B',8);
        $this->Cell(20,5,'CANTIDAD','LTBR',0,'C');
        $this->Cell(20,5,'UNIDAD','TBR',0,'C');
        $this->Cell(160,5,'DESCRIPCION','TBR',1,'C');

        $this->SetFont('Arial','',8);
        foreach($this->articulos as $articulo)
        {
            //Condición para cambio de página
            if ($this->GetY() >= 215){
                $this->AddPage();
            }

            $this->Cell(40);
            //Se calcula cuantos renglones ocupará el artículo y su descripción
            $y_inicial = $this->GetY();
            $this->MultiCell(160,5,utf8_decode($articulo->articulo),1,'L');
            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial; //Determina la altura del renglón

            $this->SetY($y_inicial);
            $this->Cell(20,$h_renglon,$articulo->cantidad,1,0,'C');
            $this->Cell(20,$h_renglon,$articulo->unidad,1,1,'C');
        }
        //Dibuja lineas cuando termina iteración
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), 220);
        $this->Line($this->GetX() + 20, $this->GetY(), $this->GetX() + 20, 220);
        $this->Line($this->GetX() + 40, $this->GetY(), $this->GetX() + 40, 220);
        $this->Line($this->GetX() + 200, $this->GetY(), $this->GetX() + 200, 220);
        $this->Line($this->GetX(), 220, 210, 220);

        $this->SetY(222);
        $this->SetFont('Arial','',8);

        //Instrucciones para envió de cotización
        $this->MultiCell(200,4,utf8_decode (''),0,'L');

        //Información de contacto (Unidad de Suministros del CU)
        $this->MultiCell(200,4,utf8_decode (''),0,'L');

        //Notas importantes
        $this->SetFont('Arial','B',8);
        $this->MultiCell(200,4,utf8_decode (''),0,'L');

        $this->Output('Req_'.$this->invitacion->req->req.'_Invita_'.$this->invitacion->id.'.pdf', 'I');
    }

}

<?php

namespace Guia\Classes\Pdfs;

use fpdf\FPDF;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Guia\Models\Cuadro;
use Guia\User;

class CuadroPdf extends FPDF {

    public $req;
    public $cuadro;

    public function __construct(Cuadro $cuadro, Collection $articulos)
    {
        $this->cuadro = $cuadro;
        $this->articulos = $articulos;
        $this->req = $cuadro->req;

        parent::__construct('L','mm','Letter');
    }

    public function Header()
    {
        $this->SetFont('Arial','',10);
        $this->Image(asset('img/membrete_adq.jpg'),10,3,0,20);
        $this->Cell(140);
        $this->Cell(100,5,'CUADRO COMPARATIVO SADMVA/'.$this->cuadro->id,0,0);
        $this->SetFont('Arial','',8);
        $this->Cell(40);
        $this->Cell(20,5,'Hoja '.$this->PageNo().'de {nb}',0,1,'R');
        $this->Cell(140);
        $this->Cell(50,5,'REQUISICION NO. '.$this->req->req,0,0);

        $responsable = User::find($this->req->user_id);
        $this->Cell(50,5,'FORMULO. '.utf8_decode($responsable->nombre),0,1);
        $this->Cell(140);
        $fecha = Carbon::parse($this->cuadro->fecha_cuadro)->format('d/m/Y');
        $this->Cell(50,5,'FECHA CUADRO: '.$fecha,0,0);
        $this->Cell(100,5,'DEPENDENCIA: '.utf8_decode($this->req->urg->d_urg),0,1);
        $this->Ln(5);

        $this->SetFont('Arial','B',7);//---Tipografía para encavezado de tabla
        $this->SetX(5);
        $this->Cell(12,22,'Cantidad',1,0,'C');
        $this->Cell(12,22,'Unidad',1,0,'C');
        $this->Cell(80,22,utf8_decode ('Descripción'),1,0,'C');
        $this->Cell(162,4,'Proveedores',1,2,'C');

        $x_prov = $this->GetX(); $y_prov = $this->GetY();

        $this->SetFont('Arial','',6);//---Tipografía para Proveedores

        $x_add = 27;
        foreach($this->cuadro->cotizaciones as $cotizacion) {
            $this->MultiCell(27,3,utf8_decode($cotizacion->benef->benef),0,'C');
            $this->Line($x_prov + $x_add, $y_prov, $x_prov + $x_add, $y_prov + 18);
            $this->SetXY($x_prov + $x_add, $y_prov);
            $x_add += 27;
        }
        $this->Line($x_prov + 162, $y_prov, $x_prov + 162, $y_prov + 18);

        $this->SetFont('Arial','',5);//---Tipografía para OC Fecha
        $this->SetXY($x_prov, $y_prov + 12);
        $no_cotizaciones = $this->cuadro->cotizaciones->count();
        $x_add = 27;
        for($i = 0; $i < $no_cotizaciones; $i++){
            $this->Cell(27,3,'No.OC',1,2,'L');
            $this->Cell(27, 3, 'FE.OC', 1, 1, 'L');
            $this->SetXY($x_prov + $x_add, $this->GetY()-6);
            $x_add += 27;
        }
        $this->Line($x_prov + $x_add - 27, $y_prov + 18, $x_prov + 162, $y_prov + 18);
        $this->Ln(6);
    }

    public function Footer()
    {
        $usuario_adq = \InfoDirectivos::getResponsable('ADQ');
        $usuario_csg = \InfoDirectivos::getResponsable('CSG');
        $usuario_sad = \InfoDirectivos::getResponsable('SAD');

        $this->SetFont('Arial','',8);
        $this->SetY(-15);
        $this->Cell(90,4,'ELABORO',0,0,'C');
        $this->Cell(90,4,'REVISO',0,0,'C');
        $this->Cell(90,4,'AUTORIZO',0,1,'C');
        $this->Cell(90,4,$usuario_adq->prefijo.' '.utf8_decode($usuario_adq->nombre),0,0,'C');
        $this->Cell(90,4,$usuario_csg->prefijo.' '.utf8_decode($usuario_csg->nombre),0,0,'C');
        $this->Cell(90,4,$usuario_sad->prefijo.' '.utf8_decode($usuario_sad->nombre),0,1,'C');

        $this->Cell(90,4,utf8_decode($usuario_adq->cargo),0,0,'C');
        $this->Cell(90,4,utf8_decode($usuario_csg->cargo),0,0,'C');
        $this->Cell(90,4,utf8_decode($usuario_sad->cargo),0,1,'C');
    }

    public function  doIfLongCell()
    {
        $this->Line($this->GetX()-24, $this->GetY(), $this->GetX()-24, 46);
        $this->Line($this->GetX()-12, $this->GetY(), $this->GetX()-12, 46);
        $this->Line($this->GetX()+107, $this->GetY(), $this->GetX()+107, 46);
        $this->Line($this->GetX()+134, $this->GetY(), $this->GetX()+134, 46);
        $this->Line($this->GetX()+161, $this->GetY(), $this->GetX()+161, 46);
        $this->Line($this->GetX()+188, $this->GetY(), $this->GetX()+188, 46);
        $this->Line($this->GetX()+215, $this->GetY(), $this->GetX()+215, 46);
        $this->Line($this->GetX()+242, $this->GetY(), $this->GetX()+242, 46);
    }

    public function crearPdf()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $no_pagina = $this->PageNo();

        foreach($this->cuadro->cotizaciones as $cotizacion)
        {
            $arr_sub_total[$cotizacion->id] = 0;
            $arr_iva[$cotizacion->id] = 0;
            $arr_total[$cotizacion->id] = 0;
        }

        foreach($this->articulos as $articulo)
        {
            $this->SetX(29);//Posisiona para imprimir la descripción del artículo
            $y_inicial = $this->GetY();

            $this->isLongCell = true;
            $this->MultiCell(80,3,utf8_decode($articulo->articulo),1,'L');
            $this->isLongCell = false;

            //Excepción para cambio de página
            //Se reinicializa la y_inicial
            if ( $no_pagina != $this->PageNo() ) {
                $y_inicial = 46;
                $no_pagina = $this->PageNo();
            }

            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial; //Determina la altura del renglón

            $this->SetXY(5,$y_inicial);
            $this->Cell(12,$h_renglon,$articulo->cantidad,1,0,'C');
            $this->Cell(12,$h_renglon,$articulo->unidad,1,0,'C');

            $no_cotizaciones_x_art = $articulo->cotizaciones->count();

            $x_prov = 109;
            $this->SetXY($x_prov, $y_inicial);
            foreach($this->cuadro->cotizaciones as $cotizacion) {
                $vacio = true;
                //Recorre las cotizaciones de cada artículo
                for($k = 0; $k < $no_cotizaciones_x_art; $k++) {
                    //Si los Id's coinciden, imprime celda
                    if($articulo->cotizaciones[$k]->id == $cotizacion->id){
                        $this->Cell(27, $h_renglon, number_format($articulo->cantidad * $articulo->cotizaciones[$k]->pivot->costo, 2), 1, 0, 'R');
                        $arr_sub_total[$cotizacion->id] += $articulo->cantidad * $articulo->cotizaciones[$k]->pivot->costo;
                        $arr_iva[$cotizacion->id] += $articulo->impuesto * 0.01 * $articulo->cantidad * $articulo->cotizaciones[$k]->pivot->costo;
                        $arr_total[$cotizacion->id] += (($articulo->impuesto * 0.01) + 1) * $articulo->cantidad * $articulo->cotizaciones[$k]->pivot->costo;
                        $vacio = false;
                    }
                }

                //Si no encuentra ninguna coincidencia, imprime la celda vacía
                if($vacio){
                    $this->Cell(27, $h_renglon, number_format(0, 2), 1, 0, 'R');
                }
            }
            $this->Ln();
        }

        //Totales
        $this->SetX($x_prov - 10);
        $this->Cell(10,4,'Sub Total '.$this->cuadro->req->moneda,0,0,'R');
        foreach($arr_sub_total as $sub_total){
            $this->Cell(27,4,number_format($sub_total,2),0,0,'R');
        }
        $this->Ln(2);

        $this->SetX($x_prov - 10);
        $this->Cell(10,4,'IVA '.$this->cuadro->req->moneda,0,0,'R');
        foreach($arr_iva as $iva){
            $this->Cell(27,4,number_format(round($iva,2),2),0,0,'R');
        }
        $this->Ln(2);

        $this->SetX($x_prov - 10);
        $this->Cell(10,4,'Total '.$this->cuadro->moneda,0,0,'R');
        foreach($arr_total as $total){
            $this->Cell(27,4,number_format($total,2),0,0,'R');
        }

        $this->Output('Req_'.$this->req->req.'_Cuadro_'.$this->cuadro->id.'.pdf', 'I');
    }
}
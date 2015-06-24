<?php

namespace Guia\Classes\Pdfs;

use fpdf\FPDF;
use Guia\Models\Almacen\Entrada;
use Guia\Models\Almacen\Salida;

class EntradaSalidaPdf extends FPDF {

    public $titulo;
    public $req;
    public $ref;
    public $ref_tipo;
    public $fecha_oc;
    public $d_proveedor;
    public $id;
    public $fecha;
    public $d_urg;
    public $cmt;
    public $usr_id;

    public function __construct($data = array())
    {
        if ($data['tipo_formato'] == 'Entrada') {
            $this->titulo = 'COMPRAS A PROVEEDOR';
        } else {
            $this->titulo = 'ENTREGAS A DEPENDENCIA';
        }

        $this->req = $data['req'];
        $this->ref_tipo = $data['ref_tipo'];
        $this->ref = $data['ref'];
        $this->fecha_oc = $data['fecha_oc'];
        $this->d_proveedor = $data['d_proveedor'];
        $this->id = $data['id'];
        $this->fecha = $data['fecha'];
        $this->d_urg = $data['d_urg'];
        $this->cmt = $data['cmt'];
        $this->usr_id = $data['usr_id'];

        parent::__construct('P','mm','Letter');
    }

    public function header()
    {
        //Header
        $this->SetFont('Arial','B', 12);
        $this->Cell(190, 5, 'Universidad de Guadalajara', 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(190, 5, 'MOVIMIENTO AL ALMACEN', 0, 1, 'C');

        //Info General
        $this->SetFont('Arial','', 10);
        $this->Ln(5);
        $this->Cell(190, 5, $this->titulo, 0, 1, 'C');

        $this->Cell(25, 5, 'Referencia', 0, 0, 'L');
        $this->Cell(105, 5, 'Req. ' .$this->req. ' / ' .$this->ref_tipo. ' ' . $this->ref .' ('.$this->fecha_oc.')', 0, 1, 'L');

        $this->Cell(25, 5, 'Proveedor', 0, 0, 'L');
        $this->Cell(105, 5, $this->d_proveedor, 0, 1, 'L');

        $this->Cell(25, 5, 'Destino', 0, 0, 'L');
        $this->Cell(105, 5, $this->d_urg, 0, 1, 'L');

        $this->Cell(130, 5, $this->cmt, 0, 0, 'L');

        //Información de Folio
        $this->SetXY(140, $this->GetY()-15);
        $this->Cell(30, 5, 'FOLIO #:', 'B', 2, 'R');
        $this->Cell(30, 5, 'Fecha Captura:', 0, 2, 'R');
        $this->Cell(30, 5, utf8_decode('Fecha Aplicación:'), 0, 2, 'R');
        $this->Cell(30, 5, utf8_decode('Usuario:'), 0, 2, 'R');

        $this->SetXY(170, $this->GetY()-20);
        $this->Cell(30, 5, $this->id, 'B', 2, 'C');
        $this->Cell(30, 5, $this->fecha, 0, 2, 'C');
        $this->Cell(30, 5, $this->fecha, 0, 2, 'C');
        $this->Cell(30, 5, $this->usr_id, 0, 1, 'C');
    }

    public function crearEntradaPdf(Entrada $entrada)
    {
        $this->AddPage();
        $sum_total = 0;

        $this->SetFont('Arial','', 10);
        $this->Cell(20, 5, utf8_decode('Código'), 'TB', 0, 'C');
        $this->Cell(90, 5, utf8_decode('Descripción'), 'TB', 0, 'C');
        $this->Cell(20, 5, 'Cantidad', 'TB', 0, 'C');
        $this->Cell(30, 5, 'Precio Unitario', 'TB', 0, 'C');
        $this->Cell(30, 5, 'Total', 'TB', 1, 'C');

        foreach($entrada->articulos as $art) {
            $y_inicial = $this->GetY();
            $this->SetX(30);
            $this->MultiCell(90, 4, utf8_decode($art->articulo), 0, 'L');
            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial;

            $this->SetY($y_inicial);
            $this->Cell(20, $h_renglon, $art->id, 0, 0, 'C');
            $this->SetXY(120, $y_inicial);
            $this->Cell(20, $h_renglon, $art->pivot->cantidad, 0, 0, 'C');
            $this->Cell(30, $h_renglon, number_format($art->costo, 2), 0, 0, 'C');
            $this->Cell(30, $h_renglon, number_format($art->costo * $art->pivot->cantidad, 2), 0, 2, 'R');

            $sum_total += $art->costo * $art->pivot->cantidad;
        }
        $this->Cell(30, 5, number_format($sum_total, 2), 'T', 2, 'R');

        $this->Output('Entrada_'.$entrada->id.'.pdf', 'I');
    }

    public function crearSalidaPdf(Salida $salida)
    {
        $this->AddPage();
        $sum_total = 0;

        //Artículos
        $this->SetFont('Arial','', 10);
        $this->Cell(20, 5, utf8_decode('Código'), 'TB', 0, 'C');
        $this->Cell(90, 5, utf8_decode('Descripción'), 'TB', 0, 'C');
        $this->Cell(20, 5, 'Cantidad', 'TB', 0, 'C');
        $this->Cell(30, 5, 'Precio Unitario', 'TB', 0, 'C');
        $this->Cell(30, 5, 'Total', 'TB', 1, 'C');

        foreach($salida->articulos as $art) {
            $y_inicial = $this->GetY();
            $this->SetX(30);
            $this->MultiCell(90, 4, utf8_decode($art->articulo), 0, 'L');
            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial;

            $this->SetY($y_inicial);
            $this->Cell(20, $h_renglon, $art->id, 0, 0, 'C');
            $this->SetXY(120, $y_inicial);
            $this->Cell(20, $h_renglon, number_format($art->cantidad), 0, 0, 'C');
            $this->Cell(30, $h_renglon, number_format($art->costo, 2), 0, 0, 'C');
            $this->Cell(30, $h_renglon, number_format($art->costo * $art->pivot->cantidad, 2), 0, 2, 'R');

            $sum_total += $art->costo * $art->pivot->cantidad;
        }
        $this->Cell(30, 5, number_format($sum_total, 2), 'T', 2, 'R');

        $this->Output('Salida_'.$salida->id.'.pdf', 'I');
    }

}
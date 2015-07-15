<?php

namespace Guia\Classes\Pdfs;

use fpdf\FPDF;
use Nat\Nat;
use Carbon\Carbon;
use Guia\Models\Oc;

class OrdenCompraPdf extends FPDF {

    public $oc;

    public function __construct(Oc $oc)
    {
        $this->oc = $oc;

        parent::__construct('P','mm','Letter');
        $this->SetFillColor(230,230,230);
        $this->AddFont('CenturyGothic','','century.php');
    }

    public function Header()
    {
        $this->Image(asset('img/logoudg.jpg'),18,3,20,0);
        //$this->Cell(20,5,'Hoja '.$this->PageNo().'de {nb}',0,1,'R');
        $this->SetXY(10, 31);
        $this->SetFont('Arial','B',7);
        $this->Cell(35, 3, utf8_decode('UNIVERSIDAD DE GUADALAJARA'), 0, 2, 'C');
        $this->Cell(35, 3, utf8_decode('Domicilio Fiscal'), 0, 2, 'C');
        $this->SetFont('Arial','',7);
        $this->Cell(35, 3, utf8_decode('Av. Juárez No. 976'), 0, 2, 'C');
        $this->Cell(35, 3, utf8_decode('Col. Centro C.P. 44100'), 0, 2, 'C');
        $this->Cell(35, 3, utf8_decode('Guadalajara, Jalisco, México.'), 0, 2, 'C');
        $this->Cell(35, 3, utf8_decode('Teléfono (33) 3134-2222'), 0, 2, 'C');
        $this->Cell(35, 3, utf8_decode('R.F.C. UGU-250907-MH5'), 0, 2, 'C');

        $this->SetXY (75,12);
        $this->SetFont('Arial','B',18);
        $this->Cell(70,5,'ORDEN DE COMPRA',0,1,'C');

        $this->Ln(1);
        $this->SetX(55);
        $this->SetFont('Arial','',8);
        $this->Cell(110,5,'CENTRO UNIVERSITARIO DE CIENCIAS EXACTAS E INGENIERIAS',1,2,'C');
        $this->SetFont('Arial','',7);
        $this->Cell(110,4,'ENTIDAD o DEPENDENCIA EMISORA','LBR',1,'C',true);

        $this->SetXY(170, 5);
        $this->SetFont('Arial','',8);
        $this->Cell(40,4,$this->oc->oc,1,2,'C');
        $this->SetFont('Arial','',6);
        $this->Cell(40,3,'NUMERO',1,1,'C',true);

        $this->SetXY(170,13);
        $this->SetFont('Arial','',8);
        $fecha = Carbon::parse($this->oc->fecha_oc)->format('d/m/Y');
        $this->Cell(40,4,$fecha,1,2,'C');
        $this->SetFont('Arial','',6);
        $this->Cell(13,3,'DIA',1,0,'C',true);
        $this->Cell(14,3,'MES',1,0,'C',true);
        $this->Cell(13,3,utf8_decode('AÑO'),1,1,'C',true);
        $this->SetX(170);
        $this->Cell(40,3,utf8_decode ('FECHA DE ELABORACIÓN'),1,1,'C',true);

        $this->SetXY(170,24);
        $this->Cell(18,3,'No. PROYECTO:',1,2,'L',true);
        $this->Cell(18,3,'No. FONDO:',1,2,'L',true);
        $this->Cell(18,3,'No. PROGRAMA:',1,2,'L',true);
        $this->Cell(40,3,'CARGO PRESUPUESTAL',1,2,'C',true);
        $this->SetXY(188,24);
        $this->Cell(22,3,utf8_decode($this->oc->req->proyecto->proyecto),1,2,'L');
        $this->Cell(22,3,utf8_decode($this->oc->req->proyecto->fondos[0]->fondo),1,2,'L');
        $this->Cell(22,3,utf8_decode(''),1,0,'L');

        $this->SetXY(45,37);
        $this->Cell(30,4,$this->oc->req->proyecto->urg->urg,1,2,'C');
        $this->Cell(30,3,utf8_decode('CÓDIGO DE URE'),1,2,'C',true);
        $this->Cell(30,4,'',1,2,'C');//ures_tel
        $this->Cell(30,3,utf8_decode('TELÉFONO'),1,0,'C',true);
        $this->SetXY(75,37);
        $this->Cell(135,4,utf8_decode($this->oc->req->proyecto->urg->d_urg),1,2,'C');
        $this->Cell(135,3,'ENTIDAD o DEPENDENCIA SOLICITANTE',1,2,'C',true);
        $this->Cell(135,4,utf8_decode(''),1,2,'C');//urg domicilio
        $this->Cell(135,3,'DOMICILIO',1,0,'C',true);

        //Verifica que exista registro en tabla proveedores
        if(count($this->oc->benef->proveedores) > 0){
            $rfc = $this->oc->benef->proveedores[0]->rfc;
            $direccion = $this->oc->benef->proveedores[0]->direccion;
        } else {
            $rfc = '';
            $direccion = '';
        }

        $this->SetXY(10,52);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), 63);
        $this->Line($this->GetX(), $this->GetY(), 75, $this->GetY());
        $this->MultiCell(65, 3, utf8_decode($direccion), 0);//prov direccion
        $this->SetXY(75,52);
        $this->Cell(135,4,  utf8_decode($this->oc->benef->benef),1,2,'C');
        $this->Cell(135,3,'PROVEEDOR',1,2,'C',true);
        $this->Cell(35,4,  utf8_decode($rfc),1,0,'C');
        $this->Cell(60,4,  utf8_decode($this->oc->benef->correo),1,0,'C');
        $this->Cell(40,4,  utf8_decode($this->oc->benef->tel),1,0,'C');
        $this->SetXY(10,63);
        $this->Cell(65,3,'DOMICILIO DEL PROVEEDOR',1,0,'C',true);
        $this->Cell(35,3,'RFC',1,0,'C',true);
        $this->Cell(60,3,utf8_decode('FAX y/o CORREO ELECTRÓNICO'),1,0,'C',true);
        $this->Cell(40,3,utf8_decode('TELÉFONO'),1,0,'C',true);

        $this->SetFont('Arial','',7);
        $this->Ln();
        $this->Cell(200,3,'LOS SIGUIENTES BIENES DEBERAN ENTREGARSE EN LAS CONDICIONES ACORDADAS',0,1,'C');
        $this->Ln(1);
    }

    public function Footer()
    {
        $this->SetFont('Arial','',6);
        $this->SetXY(10,220);
        $this->Cell(200,3,'CONDICIONES DE PAGO y ENTREGA DE BIENES',1,1,'C',true);

        $this->Cell(25,3,'FECHA DE ENTREGA:',1,0,'L',true);
        $this->Cell(47,3,utf8_decode($this->oc->condiciones->fecha_entrega),1,0,'L');
        $this->Cell(24,3,'LUGAR DE ENTREGA:',1,0,'L',true);
        $this->MultiCell(79, 3, utf8_decode($this->oc->condiciones->lugar_entrega), 1);

        $this->SetXY(10,226);
        $this->Cell(35,3,'PAGO DE CONTADO',1,0,'L');
        $this->Cell(10,3,'PAGO:',1,0,'L',true);
        $this->Cell(51,3,utf8_decode($this->oc->condiciones->pago),1,1,'L');

        $this->Cell(35,3,'PAGO EN PARCIALIDADES',1,0,'L');
        $this->Cell(27,3,'No. DE PARCIALIDADES:',1,0,'L',true);
        $this->Cell(10,3,$this->oc->condiciones->no_parcialidades,1,0,'L');
        $this->Cell(33,3,'PORCENTAJE DE ANTICIPO:',1,0,'L',true);
        $this->Cell(70,3,$this->oc->condiciones->porcentaje_anticipo.'%',1,0,'L');

        $this->SetXY(185, 223);
        $this->Cell(25,3,'FIANZAS',1,2,'C',true);
        $this->Cell(25,3,'a) ANTICIPO',1,2,'L');
        $this->Cell(25,3,'b) CUMPLIMIENTO',1,2,'L');

        //Observaciones
        $this->SetXY(10,233);
        $this->Line($this->GetX(), $this->GetY(), $this->GetX(), 245);
        $this->Line(210, $this->GetY(), 210, 245);
        $this->MultiCell(200, 3, 'No. Req. '.$this->oc->req->req.' '.utf8_decode($this->oc->condiciones->obs)."\nSolicita: ".utf8_decode($this->oc->req->user->nombre).' ()',"T");
        $this->SetXY(10,245);
        $this->Cell(200,3,'OBSERVACIONES',1,1,'C',true);

        //Firmas
        $usuario_adq = \InfoDirectivos::getResponsable('ADQ');
        $usuario_csg = \InfoDirectivos::getResponsable('CSG');
        $usuario_sad = \InfoDirectivos::getResponsable('SAD');

        $this->SetFont('Arial','',7);
        $this->SetXY(10,-20);
        $this->Cell(46,3,utf8_decode('ELABORÓ'),'T',2,'C');
        $this->MultiCell(46,3,$usuario_adq->prefijo.' '.utf8_decode($usuario_adq->nombre),0,'C');
        $this->SetX(10);
        $this->MultiCell(46,3,utf8_decode($usuario_adq->cargo),0,'C');
        $this->SetX(10);

        $this->SetXY(60,-20);
        $this->Cell(46,3,utf8_decode('REVISÓ'),'T',2,'C');
        $this->MultiCell(46,3,$usuario_csg->prefijo.' '.utf8_decode($usuario_csg->nombre),0,'C');
        $this->SetX(60);
        $this->MultiCell(46,3,utf8_decode($usuario_csg->cargo),0,'C');
        $this->SetX(60);

        $this->SetXY(115,-20);
        $this->Cell(46,3,utf8_decode('AUTORIZÓ'),'T',2,'C');
        $this->MultiCell(46,3,$usuario_sad->prefijo.' '.utf8_decode($usuario_sad->nombre),0,'C');
        $this->SetX(115);
        $this->MultiCell(46,3,utf8_decode($usuario_sad->cargo),0,'C');
        $this->SetX(115);

        $this->SetXY(165,-20);
        $this->Cell(45,3,'NOMBRE Y FIRMA DEL PROVEEDOR','T',2,'C');
        $this->MultiCell(45,3,'Acepto los terminos y condiciones que se especifican en el reveso de la presente Orden de Compra',0,'C');

    }

    public function  doIfLongCell()
    {
        $this->Line($this->GetX()-15, $this->GetY(), $this->GetX()-15, 74);
        $this->Line($this->GetX()+135, $this->GetY(), $this->GetX()+135, 74);
        $this->Line($this->GetX()+160, $this->GetY(), $this->GetX()+160, 74);
        $this->Line($this->GetX()+185, $this->GetY(), $this->GetX()+185, 74);
    }

    public function crearPdf()
    {
        $this->AliasNbPages();
        $this->SetAutoPageBreak(true, 75);
        $this->AddPage();

        //Articulos Capturados
        $this->SetFont('Arial','',6);
        $this->Cell(15,2,'UNIDAD DE','LTR',2,'C',true);
        $this->Cell(15,2,'MEDIDA','LBR',1,'C',true);
        $this->SetXY(25,$this->GetY()-4);
        $this->Cell(115,4,utf8_decode('DESCRIPCIÓN DE LOS BIENES'),1,0,'C',true);
        $this->Cell(20,4,'CANTIDAD',1,0,'C',true);
        $this->Cell(25,4,'PRECIO UNITARIO',1,0,'C',true);
        $this->Cell(25,4,'IMPORTE TOTAL',1,1,'C',true);

        $y_linea = $this->GetY();

        $no_pagina = $this->PageNo();
        $subtotal = 0;
        $sum_iva = 0;

        foreach($this->oc->articulos as $articulo)
        {
            $this->SetFont('Arial','',7);

            //Se calcula cuantos renglones ocupará el artículo y su descripción
            $this->SetX(25);
            $y_inicial = $this->GetY();
            $this->isLongCell = true;
            $this->MultiCell(115,3,utf8_decode($articulo->articulo),1,'L');
            $this->isLongCell = false;

            //Se reinicializa la y_inicial
            if ( $no_pagina != $this->PageNo() ) {
                $y_inicial = 70;
                $no_pagina = $this->PageNo();
            }

            $y_final = $this->GetY();
            $h_renglon = $y_final - $y_inicial; //Determina la altura del renglón

            $subtotal += $articulo->sub_total;
            $iva = $articulo->impuesto * 0.01 * $articulo->sub_total;
            $sum_iva += $iva;
            $this->SetXY(10,$y_inicial);
            $this->Cell(15,$h_renglon, $articulo->unidad,1,0,'C');
            $this->SetXY(140,$y_inicial);
            $this->SetFont('CenturyGothic','','7');
            $this->Cell(20,$h_renglon,$articulo->cantidad,1,0,'C');
            $this->Cell(25,$h_renglon,number_format($articulo->monto_cotizado,2),1,0,'R');
            $this->Cell(25,$h_renglon,number_format($articulo->sub_total,2),1,1,'R');
        }

        //Dibuja lineas cuando termina iteración
        $this->Line($this->GetX(), $y_linea, $this->GetX(), 207);
        $this->Line($this->GetX() + 15, $this->GetY(), $this->GetX() + 15, 207);
        $this->Line($this->GetX() + 130, $this->GetY(), $this->GetX() + 130, 207);
        $this->Line($this->GetX() + 150, $this->GetY(), $this->GetX() + 150, 207);
        $this->Line($this->GetX() + 175, $this->GetY(), $this->GetX() + 175, 207);
        $this->Line($this->GetX() + 200, $this->GetY(), $this->GetX() + 200, 207);
        //$pdf->Line($pdf->GetX(), 220, 210, 232);

        $total = $subtotal + $sum_iva;
        $nat = new Nat($total, $this->oc->req->moneda);
        $importe_letra = $nat->convertir();
        $simbolo_mondea = $this->monedas($this->oc->req->moneda);

        //Totales
        $this->SetAutoPageBreak(true, 60);
        $this->SetFont('Arial','',7);
        $this->SetXY(10,207);
        $this->Cell(150,12,'IMPORTE CON LETRA: '.$importe_letra,1,2,'L');
        $this->SetXY(160,207);
        $this->Cell(25,4,'SUB-TOTAL '.$simbolo_mondea,1,2,'R',true);
        $this->Cell(25,4,'I.V.A. '.$simbolo_mondea,1,2,'R',true);
        $this->Cell(25,4,'TOTAL '.$simbolo_mondea,1,1,'R',true);
        $this->SetXY(185,207);
        $this->SetFont('CenturyGothic','','7');
        $this->Cell(25,4,number_format($subtotal,2),1,2,'R');
        $this->Cell(25,4,number_format($sum_iva,2),1,2,'R');
        $this->Cell(25,4,number_format($total,2),1,1,'R');

        $this->Output('Req_'.$this->oc->req->req.'_OC_'.$this->oc->oc.'.pdf', 'I');
    }

    private function monedas($moneda)
    {
        switch ($moneda)
        {
            case "Libras": $simbolo_moneda = "£"; break;
            case "Euros": $simbolo_moneda = "€"; break;
            case "Yenes": $simbolo_moneda = "¥"; break;
            case "USD": $simbolo_moneda = "USD"; break;
            default: $simbolo_moneda = "$";
        }
        $simbolo_moneda = iconv('UTF-8', 'windows-1252', $simbolo_moneda);

        return $simbolo_moneda;
    }

}
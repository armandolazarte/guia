<?php

namespace Guia\Classes\Pdfs;

use Carbon\Carbon;
use fpdf\FPDF;
use Guia\Classes\Utility;
use Guia\Models\Solicitud;
use Guia\User;

class SolicitudPdf extends FPDF
{
    public $solicitud;
    public $solicita;
    public $autoriza;
    public $vobo;

    public function __construct(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;

        parent::__construct('P','mm','Letter');
        $this->SetFillColor(200,200,200);
        $this->AddFont('CenturyGothic','','century.php');
        $this->SetFont('CenturyGothic','','10');
        $this->getUsuarios();
    }

    private function getUsuarios()
    {
        $this->solicita = User::find($this->solicitud->solicita);
        if ($this->solicitud->solicita != $this->solicitud->autoriza){
            $this->autoriza = User::find($this->solicitud->autoriza);
        }
        if ($this->solicitud->solicita != $this->solicitud->vobo) {
            $this->vobo = User::find($this->solicitud->vobo);
        }
    }

    public function Header()
    {
        $this->SetFont('Arial','B',11);
        $this->Image(asset('img/Header_UDG_2014_CUCEI.jpg'),10,10,0,25);

        $this->SetY(35);
        $this->Cell(190,5,'Solicitud de Recursos',0,2,'C');
        $this->Ln();
    }

    public function crearPdf()
    {
        $this->AliasNbPages();
        $this->SetAutoPageBreak(true, 45);
        $this->AddPage();

        $usuario_finanzas = \InfoDirectivos::getResponsable('FIN');
        $usuario_presu = \InfoDirectivos::getResponsable('PRESU');

        $this->SetFont('Arial','B',11);
        $this->SetX(25);
        $this->Cell(180,5,'OFICIO NO.'.$this->solicitud->no_documento,0,2,'R');
        $this->Ln(5);

        $this->SetX(25);
        $this->Cell(180, 5, utf8_decode($usuario_finanzas->prefijo." ".$usuario_finanzas->nombre), 0, 2, "L");
        $this->Cell(180, 5, utf8_decode($usuario_finanzas->cargo), 0, 2, "L");
        $this->Cell(180, 5, "CUCEI", 0, 2, "L");
        $this->Cell(180, 5, "P R E S E N T E", 0, 2, "L");
        $this->Cell(180, 5, utf8_decode("At'n. ".$usuario_presu->prefijo." ".$usuario_presu->nombre), 0, 2, "R");
        $this->Cell(180, 5, utf8_decode($usuario_presu->cargo), 0, 2, "R");
        $this->Ln();

        $this->SetFont('Arial','',10);
        $this->SetX(25);
        $this->Cell(71,4,'Por medio del presente solicito el tramite de:',0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->Cell(70,4,$this->solicitud->tipo_solicitud,0,1,'L');
        $this->SetFont('Arial','',10);
        $this->Ln();

        $this->SetX(25);
        $this->Cell(60,4,'Dicho recurso se solicita para:',0,2,'L');
        $this->SetFont('Arial','',9);
        $this->MultiCell(180, 3.5, utf8_decode ($this->solicitud->concepto), 0, "L");
        $this->Ln(5);

        $this->SetX(25);
        $this->Cell(28,4,'Cheque a favor de:',0,0,'L');
        $this->SetFont('Arial','B',10);
        $this->MultiCell(145,4,utf8_decode($this->solicitud->benef->benef),"B",'L');
        $this->SetFont('Arial','',10);
        $this->Ln();

        $this->SetX(25);
        $this->Cell(28,4,'Por el monto de:',0,0,'L');
        $this->SetFont('CenturyGothic','','10');
        $this->Cell(145,4,"$ ".number_format($this->solicitud->monto,2),"B",1,'L');
        $this->SetFont('Arial','',10);
        $this->Ln();

        if (!empty($this->solicitud->obs)) {
            $this->Ln(3);
            $this->SetX(25);
            $this->Cell(28, 3.5, 'Observaciones:', 0, 0, 'L');
            $this->SetFont('Arial', '', 9);
            $this->MultiCell(155, 3.5, utf8_decode($this->solicitud->obs), 0, "L");
            $this->Ln();
        }

        $this->SetX(25);
        $this->SetFont('Arial','',10);
        $this->Cell(180, 4, "URES:     ".$this->solicitud->urg->urg." ".utf8_decode ($this->solicitud->urg->d_urg), 0, 2, "L");
        $this->Cell(180, 4, "Proyecto: ".$this->solicitud->proyecto->proyecto. " ".utf8_decode ($this->solicitud->proyecto->d_proyecto), 0, 2, "L");
        $this->Cell(180, 4, "Fondo:     ".$this->solicitud->proyecto->fondos->first()->fondo, 0, 2, "L");
        $this->Ln();

        $this->SetFont('Arial','',10);
        $this->SetX(25);

        if (count($this->solicitud->objetivos) > 0){
            $this->MultiCell(60,5,"Desglose por Objetivo:",1,'C');
            $this->SetFont('CenturyGothic','','10');
            foreach($this->solicitud->objetivos as $obj){
                $this->SetX(25);
                $this->Cell(40, 5, $obj->objetivo, 1, 0, 'C');
                $this->Cell(20, 5, number_format($obj->pivot->monto,2), 1, 1, 'R');
            }
        } else {
            $y_tabla_rm_inicio = $this->GetY();
            $this->SetFont('CenturyGothic','','10');
            $i = 0;
            foreach ($this->solicitud->rms as $rm) {
                switch ($i) {
                    case 0:
                        $this->SetXY(25, $y_tabla_rm_inicio);
                        $this->Cell(58,5,"Desglose por RM/Cuenta",1, 2,'C');
                        break;
                    case 6:
                        $y_tabla_rm_fin = $this->GetY();
                        $this->SetXY(85, $y_tabla_rm_inicio);
                        $this->Cell(58,5,"Desglose por RM/Cuenta",1, 1,'C');
                        break;
                    case 12:
                        $this->SetXY(145, $y_tabla_rm_inicio);
                        $this->Cell(58,5,"Desglose por RM/Cuenta",1, 1,'C');
                        break;
                }

                if ($i < 6) {
                    $x_total = 25;
                    $this->SetX(25);
                } elseif ($i >= 6 || $i < 12) {
                    $x_total = 85;
                    $this->SetX(85);
                } else {
                    $x_total = 145;
                    $this->SetX(145);
                }

                $this->Cell(20, 5, $rm->rm, 1, 0, "C");
                $this->Cell(15, 5, $rm->cog->cog, 1, 0, "C");
                $this->Cell(23, 5, number_format($rm->pivot->monto,2), 1, 1, "R");
                $i++;
            }
        }

        $this->SetFont('Arial','B',10);
        $this->SetX($x_total);
        $this->Cell(35, 5, "TOTAL", 1, 0, "C");
        $this->SetFont('CenturyGothic','','10');
        $this->Cell(23, 5, number_format($this->solicitud->monto,2), 1, 1, "R");
        $this->SetFont('Arial','',11);
        if ($i > 6) {
            $this->SetY($y_tabla_rm_fin);
        }
        $this->Ln();

        //Tabla Finanzas
        $this->SetFont('Arial','',9);
        $y_tabla = $this->GetY();
        $this->SetXY(25,$y_tabla);
        $this->MultiCell(180,4,utf8_decode('Uso Exlusivo Finanzas Coordinación de Finanzas'),1,'C');
        $this->SetXY(25,$y_tabla+4);
        //$pdf->MultiCell(30,4,"Tipo de Solicitud Capturada",1,'C');
        $this->SetXY(25,$y_tabla+4);
        $this->MultiCell(30,4,'No. Documento AFIN',1,'C');
        $this->SetXY(55,$y_tabla+4);
        $this->MultiCell(30,4,'No. Solicitud de Pago AFIN',1,'C');
        $this->SetXY(85,$y_tabla+4);
        $this->MultiCell(30,4,'No. de Facturas AFIN',1,'C');
        $this->SetXY(115,$y_tabla+4);
        $this->MultiCell(30,4,"No. de Cheque\n ",1,'C');
        $this->SetXY(145,$y_tabla+4);
        $this->MultiCell(30,4,"No. Pago AFIN\n ",1,'C');
        $this->SetXY(175,$y_tabla+4);
        $this->MultiCell(30,4,utf8_decode('No. de Comprobación'),1,'C');

        $this->SetX(25);
        $this->Cell(30,5,'',1,0,'C');
        $this->Cell(30,5,'',1,0,'C');
        $this->Cell(30,5,'',1,0,'C');
        $this->Cell(30,5,'',1,0,'C');
        $this->Cell(30,5,'',1,0,'C');
        $this->Cell(30,5,'',1,1,'C');
        //Fin de Tabla

        $this->SetAutoPageBreak(true,5);
        //Tabla Vo.Bo.'s
        $this->SetFont('Arial','',8);
        $this->SetXY(-60,-20);
        $this->Cell(30,4,  utf8_decode('Revisó'),0,0,'C');
        $this->Cell(30,4,'Vo.Bo.',0,1,'C');

        $this->SetX(-60);
        $this->Cell(30,4,$usuario_presu->iniciales,0,0,'C');
        $this->Cell(30,4,$usuario_finanzas->iniciales,0,1,'C');
        //Fin de Tabla

        //Footer no repetitivo por fecha y # de solicitud
        $solicita = User::find($this->solicitud->solicita);
        $this->SetY(-44);
        $this->SetFont('Arial','',10);

        $fecha_texto = Utility::fecha_texto($this->solicitud->fecha);

        //Verificar si el responsable del proyecto es el solicitante
        if($this->solicitud->autoriza == $this->solicitud->solicita || $this->solicitud->autoriza == 0) {
            $this->Cell(190, 5, "A T E N T A M E N T E", 0, 1, "C");
            $this->SetFont('Arial','B',10);
            $this->Cell(190,4,utf8_decode ("\"Piensa y Trabaja\""),0,1,'C');
//            if (!empty($LEYENDA)) {
//                $this->SetFont('Arial','BI',10);
//                $this->Cell(190,4,utf8_decode (""),0,1,'C');//Leyenda
//            }
            $this->SetFont('Arial','',10);
            $this->Cell(190,4,utf8_decode ("Guadalajara, Jalisco, a ".$fecha_texto),0,1,'C');
            $this->Ln(10);

            $this->MultiCell(190,5,utf8_decode($solicita->prefijo." ".$solicita->nombre),0,'C');
            $this->MultiCell(190,5,utf8_decode($solicita->cargo),0,'C');
        } else {
            //Firma de solicitante y responsable
            $this->Cell(90, 5, "A T E N T A M E N T E",10, 1, "L");
            $this->SetFont('Arial','B',10);
            $this->Cell(90,4,utf8_decode ("\"Piensa y Trabaja\""),0,1,'L');
//            if (!empty($LEYENDA)) {
//                $this->SetFont('Arial','BI',10);
//                $this->Cell(90,4,utf8_decode ("$LEYENDA"),0,1,'L');
//            }
            $this->SetFont('Arial','',10);
            $this->Cell(90,4,utf8_decode ("Guadalajara, Jalisco, a ".$fecha_texto),0,1,'L');
            $this->Ln(11);

            $this->MultiCell(90,5,utf8_decode($solicita->prefijo." ".$solicita->nombre),0,'L');
            $this->MultiCell(90,5,utf8_decode($solicita->cargo),0,'L');

            $autoriza = User::find($this->solicitud->autoriza);
            $this->SetXY(95,-20);
            $this->SetFont('Arial','',8);
            $this->Cell(65, 4, "AUTORIZA", 0, 2, "C");
            $this->MultiCell(65,4,utf8_decode($autoriza->prefijo." ".$autoriza->nombre),0,'C');
            $this->SetX(95);
            $this->MultiCell(65,4,utf8_decode($autoriza->cargo),0,'C');
        }

        $this->SetFont('Arial','',7);
        $this->SetXY(-40, -10);
        $this->Cell(35, 4, "Solicitud SIGI #".$this->solicitud->id, 0, 1, "R");

        $this->Output('Solicitud_'.$this->solicitud->id.'.pdf', 'I');

    }
}
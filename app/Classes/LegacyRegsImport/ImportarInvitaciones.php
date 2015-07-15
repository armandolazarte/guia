<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Articulo;
use Guia\Models\Benef;
use Guia\Models\Cotizacion;
use Guia\Models\Cuadro;
use Guia\Models\Req;

class ImportarInvitaciones
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;

    public function __construct($db_origen, $col_rango, $arr_rango)
    {
        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        if(!empty($id_fin)) {
            $this->id_fin = $id_fin;
        }

        $this->db_origen = $db_origen;

        set_time_limit(240);
    }

    public function importarInvitaciones()
    {
        $legacy_invitaciones = $this->consultarInvitacionesLegacy();

        foreach ($legacy_invitaciones as $invita_legacy) {
            $req = Req::whereReq($invita_legacy->req)->first(['id', 'estatus']);
            $fecha_cuadro = \DB::connection($this->db_origen)->table('tbl_req')->where('req', '=', $invita_legacy->req)->pluck('fecha_cuadro');

            $cuadro_legacy = $this->consultarCuadroLegacy($invita_legacy->req);
            $articulos = Articulo::whereReqId($req->id)->get(['id']);
            if(count($articulos) > 0) {

                $cuadro_id = $this->crearCuadro($req, $fecha_cuadro);

                for ($i = 1; $i < 7; $i++) {
                    $benef_id_i = 'benef_id_' . $i;

                    if (!empty($invita_legacy->$benef_id_i)) {
                        $fecha_invita_i = 'fecha_invita_' . $i;

                        //Extrae de invitación para poblar una nueva cotización
                        $benef_id = $this->getBenefId($invita_legacy->$benef_id_i);

                        $cotiza_nueva = new Cotizacion();
                        $cotiza_nueva->req_id = $req->id;
                        $cotiza_nueva->cuadro_id = $cuadro_id;
                        $cotiza_nueva->benef_id = $benef_id;
                        $cotiza_nueva->fecha_invitacion = $invita_legacy->$fecha_invita_i;
                        $cotiza_nueva->save();

                        //extrae información de cuadro para poblar articulo_cotizacion

                        if(count($cuadro_legacy) > 0) {

                            if(count($articulos) != count($cuadro_legacy)){
                                dd($req->id.' #Articulos: '.count($articulos).' #Cuadro: '.count($cuadro_legacy));
                            }

                            $k = 0;
                            foreach ($cuadro_legacy as $cotizacion_legacy) {
                                $costo_i = 'costo_' . $i;
                                $sel_i = 'sel_' . $i;
                                if ($cotizacion_legacy->$costo_i > 0) {

                                    if ($cotizacion_legacy->$sel_i == 'S') {
                                        $sel = 1;
                                    } else {
                                        $sel = 0;
                                    }

                                    $cotiza_nueva->articulos()->attach($articulos[$k]->id, [
                                        'costo' => $cotizacion_legacy->$costo_i,
                                        'sel' => $sel
                                    ]);
                                }
                                $k++;
                            }
                        }
                    }
                }
            }
            else {
                dd($req->id);
            }
        }
    }

    private function crearCuadro($req, $fecha_cuadro)
    {
        //Creación de cuadros
        if($req->estatus == 'Cotizada' || $req->estatus == 'Autorizada' || $req->estatus == 'Pagada') {
            $estatus_cuadro = 'Terminado';
        } else {
            $estatus_cuadro = '';
        }

        $user_adq = \InfoDirectivos::getResponsable('ADQ');
        $user_csg = \InfoDirectivos::getResponsable('CSG');
        $user_sad = \InfoDirectivos::getResponsable('SAD');

        $cuadro = new Cuadro();
        $cuadro->req_id = $req->id;
        $cuadro->fecha_cuadro = $fecha_cuadro;
        $cuadro->estatus = $estatus_cuadro;
        $cuadro->elabora = $user_adq->id;//Suministros
        $cuadro->revisa = $user_csg->id;//Serv. Generales
        $cuadro->autoriza = $user_sad->id;//SAD
        $cuadro->save();

        return $cuadro->id;
    }

    private function consultarCuadroLegacy($req)
    {
        $cuadro_legacy = \DB::connection($this->db_origen)->table('tbl_cuadro')
            ->where('req', '=', $req)
            ->get();

        return $cuadro_legacy;
    }

    private function getBenefId($legacy_benef_id)
    {
        $benef = \DB::connection('legacy_benef')
            ->table('tbl_benef')
            ->where('benef_id', '=', $legacy_benef_id)
            ->value('benef');

        $benef_id = Benef::whereBenef($benef)->pluck('id');
        return $benef_id;
    }

    private function consultarInvitacionesLegacy()
    {
        $invitaciones_legacy = \DB::connection($this->db_origen)->table('tbl_invita');
        if(!empty($this->col_rango)){
            $invitaciones_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }

        return $invitaciones_legacy->get();
    }

    public function actualizarFechaCuadro()
    {
        $legacy_reqs = \DB::connection($this->db_origen)->table('tbl_req')->get(['req','fecha_cuadro']);
        foreach ($legacy_reqs as $legacy_req) {
            $req_id = Req::whereReq($legacy_req->req)->pluck('id');
            Cuadro::whereReqId($req_id)->update(['fecha_cuadro' => $legacy_req->fecha_cuadro]);
        }
    }
}

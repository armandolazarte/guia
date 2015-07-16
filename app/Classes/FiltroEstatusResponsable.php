<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 02/06/2015
 * Time: 01:02 PM
 */

namespace Guia\Classes;


class FiltroEstatusResponsable
{
    private $user;
    private $arr_roles;
    public $arr_estatus;
    public $arr_responsable;

    public function __construct($user = null)
    {
        if(empty($user)){
            $this->user = \Auth::user();
            $this->user->load('roles');
        }

        $this->arr_roles = $this->user->roles()->lists('role_name')->all();

    }

    public function filtroReqs()
    {
        $this->setEstatusReqs();
        if(array_search('Cotizador', $this->arr_roles) !== false || array_search('Adquisiciones', $this->arr_roles) !== false) {
            $this->setResponsable();
        }
    }

    public function filtroSolicitudes()
    {
        $this->setEstatusSolicitudes();
    }

    private function setEstatusReqs()
    {
        $arr_estatus = Array();

        if(array_search('Cotizador', $this->arr_roles) !== false || array_search('Adquisiciones', $this->arr_roles) !== false) {
            $arr_estatus = ['Enviada', 'Recibida', 'Cotizando', 'Cotizada', 'Autorizada', 'Pagada'];
        }

        if(array_search('Presupuesto', $this->arr_roles) !== false || array_search('Comprobacion', $this->arr_roles) !== false) {
            $arr_estatus = ['Cotizada', 'Autorizada', 'Pagada'];
        }

        $this->arr_estatus = $arr_estatus;
    }

    private function setEstatusSolicitudes()
    {
        $arr_estatus = Array();

        if(array_search('Presupuesto', $this->arr_roles) !== false || array_search('Comprobacion', $this->arr_roles) !== false) {
            $arr_estatus = ['Enviada', 'Autorizada', 'Recibida'];
        }

        $this->arr_estatus = $arr_estatus;
    }

    private function setResponsable()
    {
        $arr_responsable = Array();
        if(array_search('Cotizador', $this->arr_roles) !== false || array_search('Adquisiciones', $this->arr_roles) !== false) {
            $arr_responsable = [$this->user->id];
        }

        $this->arr_responsable = $arr_responsable;
    }
}
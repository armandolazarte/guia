<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PaginasController extends Controller {

	public function inicio()
    {
        return view('paginas.inicio');
    }

    public function formatos()
    {
        return view('paginas.formatos');
    }

    public function acercade()
    {
        return view('paginas.acercade');
    }

    public function manuales()
    {
        return view('paginas.manuales');
    }

    public function normatividad()
    {
        return view('paginas.normatividad');
    }
}

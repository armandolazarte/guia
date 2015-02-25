<?php

namespace Guia\Http\Composers;

use Illuminate\Contracts\View\View;

class FiltroPresupuestoComposer
{
    public $data;

    public function __construct()
    {
        $this->data['presupuesto_inicial'] = env('PRESUPUESTO_INICIAL', '2010');
        $this->data['presupuesto_actual'] = \Carbon\Carbon::now()->year;
        $this->data['sel_presupuesto'] = \Session::get('sel_presupuesto');
    }

    public function compose(View $view)
    {
        $view->with($this->data);
    }
}
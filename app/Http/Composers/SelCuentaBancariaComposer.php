<?php

namespace Guia\Http\Composers;


use Guia\Models\CuentaBancaria;
use Illuminate\Contracts\View\View;

class SelCuentaBancariaComposer
{
    protected $data;

    public function __construct()
    {
        $this->data['cuentas_bancarias'] = CuentaBancaria::all()->lists('cuenta_tipo_urg','id')->all();

        $this->data['meses'] = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        $this->data['presupuesto_inicial'] = env('PRESUPUESTO_INICIAL', '2010');
        $this->data['presupuesto_actual'] = \Carbon\Carbon::now()->year;
        $this->data['sel_presupuesto'] = \Session::get('sel_presupuesto');
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with($this->data);
    }
}

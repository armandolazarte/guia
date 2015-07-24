<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Cuenta;

class CuentasTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Cuenta::create(['cuenta' => 'Presupuesto', 'tipo' => 'Ejecutora']);
        Cuenta::create(['cuenta' => 'ReintegroDF', 'tipo' => 'Ejecutora']);
        Cuenta::create(['cuenta' => 'Recursos Presupuesto (Ministración)', 'tipo' => 'Ejecutora']);
        Cuenta::create(['cuenta' => 'Comisiones Bancarias', 'tipo' => 'BancoCargo']);
        Cuenta::create(['cuenta' => 'Abono Bancario', 'tipo' => 'BancoAbono']);
        Cuenta::create(['cuenta' => 'Inversión', 'tipo' => 'Banco']);
        Cuenta::create(['cuenta' => 'Intereses', 'tipo' => 'BancoAbono']);
        Cuenta::create(['cuenta' => 'Facturación', 'tipo' => 'Banco']);
        Cuenta::create(['cuenta' => 'Equivocado', 'tipo' => 'Banco']);
        Cuenta::create(['cuenta' => 'No Identificado', 'tipo' => 'BancoAbono']);

        Cuenta::create(['cuenta' => 'PROMEP', 'tipo' => 'ComunOtro']);
        Cuenta::create(['cuenta' => 'CA', 'tipo' => 'PuenteExt']);
        Cuenta::create(['cuenta' => 'Donativo', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Congreso', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Convenio', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Taller', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Diplomado', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Devolucion Recursos', 'tipo' => 'PuenteDev']);
        Cuenta::create(['cuenta' => 'VARIOS', 'tipo' => 'ComunOtro']);
        Cuenta::create(['cuenta' => 'Aportaciones Especiales', 'tipo' => 'PuenteOtro']);
        Cuenta::create(['cuenta' => 'Fondo Fijo de Caja', 'tipo' => 'ComunOtro']);
        Cuenta::create(['cuenta' => 'Apertura de Cuenta', 'tipo' => 'BancoAbono']);
        Cuenta::create(['cuenta' => 'I0110/186/10 (MUJERES)', 'tipo' => 'PuenteExt']);
        Cuenta::create(['cuenta' => 'Retención ISR', 'tipo' => 'Ejecutora']);
    }

}
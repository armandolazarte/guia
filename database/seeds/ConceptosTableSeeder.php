<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Concepto;

class ConceptosTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Concepto::create(['concepto' => 'Presupuesto', 'tipo' => 'Ejecutora']);
        Concepto::create(['concepto' => 'Recursos Presupuesto (Ministración)', 'tipo' => 'Ejecutora']);
        Concepto::create(['concepto' => 'Comisiones Bancarias', 'tipo' => 'BancoCargo']);
        Concepto::create(['concepto' => 'Abono Bancario', 'tipo' => 'BancoAbono']);
        Concepto::create(['concepto' => 'Inversión', 'tipo' => 'Banco']);
        Concepto::create(['concepto' => 'Intereses', 'tipo' => 'BancoAbono']);
        Concepto::create(['concepto' => 'Facturación', 'tipo' => 'Banco']);
        Concepto::create(['concepto' => 'Equivocado', 'tipo' => 'Banco']);
        Concepto::create(['concepto' => 'No Identificado', 'tipo' => 'BancoAbono']);

        Concepto::create(['concepto' => 'PROMEP', 'tipo' => 'ComunOtro']);
        Concepto::create(['concepto' => 'CA', 'tipo' => 'PuenteExt']);
        Concepto::create(['concepto' => 'Donativo', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Congreso', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Convenio', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Taller', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Diplomado', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Devolucion Recursos', 'tipo' => 'PuenteDev']);
        Concepto::create(['concepto' => 'VARIOS', 'tipo' => 'ComunOtro']);
        Concepto::create(['concepto' => 'Aportaciones Especiales', 'tipo' => 'PuenteOtro']);
        Concepto::create(['concepto' => 'Fondo Fijo de Caja', 'tipo' => 'ComunOtro']);
        Concepto::create(['concepto' => 'Apertura de Cuenta', 'tipo' => 'BancoAbono']);
        Concepto::create(['concepto' => 'I0110/186/10 (MUJERES)', 'tipo' => 'PuenteExt']);
    }

}
<?php

use Illuminate\Database\Seeder;
use Guia\Models\Grupo;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create(['grupo' => 'Presupuesto', 'tipo' => 'Finanzas Colectivo']);
        Grupo::create(['grupo' => 'Contabilidad', 'tipo' => 'Finanzas Colectivo']);
        Grupo::create(['grupo' => 'Comprobación', 'tipo' => 'Finanzas Individual']);
        Grupo::create(['grupo' => 'Recepción', 'tipo' => 'Finanzas Colectivo']);
        Grupo::create(['grupo' => 'Unidad Suministros', 'tipo' => 'Suministros Individual']);
        Grupo::create(['grupo' => 'Cotización', 'tipo' => 'Suministros Individual']);
        Grupo::create(['grupo' => 'Investigadores', 'tipo' => 'Usuarios']);
    }
}

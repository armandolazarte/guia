<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Role;

class RolesTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        $root = Role::create(array('role_name' => 'Root'));
        $root->modulos()->attach([1,2,3]);
        Role::create(array('role_name' => 'Administrador'));
        Role::create(array('role_name' => 'Usuario'));
        Role::create(array('role_name' => 'Adquisiciones'));
        Role::create(array('role_name' => 'Cotizador'));
        Role::create(array('role_name' => 'Patrimonio'));
        Role::create(array('role_name' => 'Directivo'));
        Role::create(array('role_name' => 'Recepción'));
        Role::create(array('role_name' => 'Presupuesto'));
        Role::create(array('role_name' => 'Ejecutora'));
        Role::create(array('role_name' => 'Contabilidad'));
        Role::create(array('role_name' => 'Comprobacion'));
        Role::create(array('role_name' => 'Bancos'));
        Role::create(array('role_name' => 'Fondos Externos'));
        Role::create(array('role_name' => 'DMCYP - DIP'));
    }
}
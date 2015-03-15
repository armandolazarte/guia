<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\User;

class UserTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        $psw = Hash::make('toor');
        User::create(array(
            'username' => 'root',
            'email' => 'root@sysadmin.com',
            'password' => $psw,
            'nombre' => 'Root',
            'cargo' => 'Administrador del Sistema',
            'prefijo' => '',
            'iniciales' => '',
            'remember_token' => ''
        ));

        $psw = Hash::make('1234');
        User::create(array(
            'username' => '1234',
            'email' => 'usuario@prueba.com',
            'password' => $psw,
            'nombre' => 'Usuario de Prueba',
            'cargo' => 'Cargo Prueba',
            'prefijo' => 'Ing',
            'iniciales' => '',
            'remember_token' => ''
        ));
    }
}
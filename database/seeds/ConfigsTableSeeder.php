<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Config;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Config::create(['variable' => 'IVA', 'valor' => '16', 'fecha_inicio' => '2010-01-01', 'fecha_fin' => '0000-00-00']);
    }
}

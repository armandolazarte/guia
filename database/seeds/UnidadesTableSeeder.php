<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Unidad;

class UnidadesTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Unidad::create(array('unidad' => 'Caja', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Equipo', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Frasco', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Kit', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Paquete', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Pieza','tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Rollo', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Unidad', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'Vial', 'tipo' => 'Uso Frecuente'));
        Unidad::create(array('unidad' => 'gr', 'tipo' => 'Sis. Métrico'));
        Unidad::create(array('unidad' => 'Kg', 'tipo' => 'Sis. Métrico'));
        Unidad::create(array('unidad' => 'Lt', 'tipo' => 'Sis. Métrico'));
        Unidad::create(array('unidad' => 'Metros', 'tipo' => 'Sis. Métrico'));
        Unidad::create(array('unidad' => 'Mtr. Cúbico', 'tipo' => 'Sis. Métrico'));
        Unidad::create(array('unidad' => 'Libras', 'tipo' => 'Sis. Inglés'));
        Unidad::create(array('unidad' => 'Onzas', 'tipo' => 'Sis. Inglés'));
        Unidad::create(array('unidad' => 'Diseño', 'tipo' => 'Servicios'));
        Unidad::create(array('unidad' => 'Servicio', 'tipo' => 'Servicios'));
        Unidad::create(array('unidad' => 'Pares', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Galón', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Tramo', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Tubo', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Torre', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Costal', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Cubeta', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Viaje', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Cilindro', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Bolsa', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Juego', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Hojas', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Manojo', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Carrete', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Pliego', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Cargas', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Postes', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Vales', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Bobina', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Licencia', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Garrafón', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Saco', 'tipo' => 'Otros'));
        Unidad::create(array('unidad' => 'Muestras', 'tipo' => 'Otros'));
    }
}
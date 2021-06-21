<?php

namespace Database\Seeders;

use App\Models\UnidadMedidaB1;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedidaB1::create([
            'nombre' => 'Metro',
            'magnitud' => 'Longitud',
            'simbolo' => 'm',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Libra',
            'magnitud' => 'Peso',
            'simbolo' => 'lb',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Pulgada',
            'magnitud' => 'Longitud',
            'simbolo' => 'plg',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Centimetro',
            'magnitud' => 'Longitud',
            'simbolo' => 'cm',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Unidad',
            'magnitud' => 'Unidad',
            'simbolo' => 'C/U',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Yarda',
            'magnitud' => 'Longitud',
            'simbolo' => 'yrd',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Pie',
            'magnitud' => 'Longitud',
            'simbolo' => 'pie',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Galon',
            'magnitud' => 'Galon',
            'simbolo' => 'gal',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Pliego',
            'magnitud' => 'Pliego',
            'simbolo' => 'pliego',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Rollo',
            'magnitud' => 'Rollo',
            'simbolo' => 'rollo',
            'activo' => '1'
        ]);

        UnidadMedidaB1::create([
            'nombre' => 'Par',
            'magnitud' => 'Unidad',
            'simbolo' => 'Par',
            'activo' => '1'
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\TiposB1;
use Illuminate\Database\Seeder;

class TiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TiposB1::create([
            'nombre' => 'Repuestos',
            'descripcion' => '',
            'activo' => 1
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\EstadoProyectoB3;
use Illuminate\Database\Seeder;

class EstadoProyectoSeeder extends Seeder
{
    /**
     * Estado del proyecto
     *
     * @return void
     */
    public function run()
    {
        // ID 1: en ejecucion
        EstadoProyectoB3::create([
            'nombre' => 'En Ejecución',
        ]);

        // ID 2: Terminado
        EstadoProyectoB3::create([
            'nombre' => 'Terminado',
        ]);
    }
}

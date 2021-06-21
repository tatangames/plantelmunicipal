<?php

namespace Database\Seeders;

use App\Models\CondicionB1;
use Illuminate\Database\Seeder;

class CondicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CondicionB1::create([
            'nombre' => 'NUEVO',
        ]);

        CondicionB1::create([
            'nombre' => 'USADO',
        ]);
    }
}

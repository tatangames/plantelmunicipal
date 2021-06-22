<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrador
        Usuario::create([
            'nombre' => 'Jonathan Moran',
            'usuario' => 'jonathan',
            'password' => bcrypt('TatanAdmin10'),
            'activo' => '1'
        ])->assignRole('Super-Admin');

        // Bodegero1
        Usuario::create([
            'nombre' => 'Ciro Cruz',
            'usuario' => 'ciro',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Bodeguero1-Admin');
    }
}

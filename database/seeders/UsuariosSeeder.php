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
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Super-Admin');

        // Bodegero1 admin 1
        Usuario::create([
            'nombre' => 'Ciro Cruz',
            'usuario' => 'ciro',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema1-Admin1');

        // Bodegero1 admin 2
        Usuario::create([
            'nombre' => 'Marcos',
            'usuario' => 'marcos',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema1-Admin2');

        // Bodegero1 admin 3
        Usuario::create([
            'nombre' => 'Informativo Bodega 1',
            'usuario' => 'bodega1info',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema1-Admin3');

        // Bodegero2
        Usuario::create([
            'nombre' => 'Marlene',
            'usuario' => 'marlene',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema2-Admin1');

        // Bodegero3 admin 1
        Usuario::create([
            'nombre' => 'Esmeralda',
            'usuario' => 'esmeralda',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema3-Admin1');

        // Bodegero3 admin 2
        Usuario::create([
            'nombre' => 'Don Luis',
            'usuario' => 'luis',
            'password' => bcrypt('admin'),
            'activo' => '1'
        ])->assignRole('Sistema3-Admin2');
    }


}

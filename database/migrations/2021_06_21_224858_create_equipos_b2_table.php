<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposB2Table extends Migration
{
    /**
     * Sistema para marlene - Registrar compras para cada equipo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos_b2', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->boolean('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipos_b2');
    }
}

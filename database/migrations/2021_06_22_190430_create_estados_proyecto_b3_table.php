<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosProyectoB3Table extends Migration
{
    /**
     * Sistema para bodega Bienes Municipales
     * 1- En Ejecucion
     * 2- Terminado
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_proyecto_b3', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados_proyecto_b3');
    }
}

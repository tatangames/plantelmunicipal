<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroBodegaB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_bodega_b1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuarios')->unsigned();

            // nombre de la persona que solicito este repuesto
            // sino se coloca el nombre se pondra el default id 1
            // que sera "Sin Nombre"
            $table->bigInteger('id_persona')->unsigned();

            $table->bigInteger('id_equipo')->unsigned();

            // nota general
            $table->string('nota', 800)->nullable();

            $table->dateTime('fecha');

            $table->foreign('id_equipo')->references('id')->on('equipos_b1');
            $table->foreign('id_usuarios')->references('id')->on('usuarios');
            $table->foreign('id_persona')->references('id')->on('persona_b1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_bodega_b1');
    }
}

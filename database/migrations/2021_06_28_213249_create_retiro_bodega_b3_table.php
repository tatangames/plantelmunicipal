<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroBodegaB3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_bodega_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();
            $table->bigInteger('id_usuarios')->unsigned();
            $table->bigInteger('id_tipo_retiro_b3')->unsigned();
            $table->bigInteger('id_bodega_b3')->unsigned();

            // nota general
            $table->string('nota', 500)->nullable();

            $table->dateTime('fecha');

            $table->foreign('id_ingresos_b3')->references('id')->on('ingresos_b3');
            $table->foreign('id_usuarios')->references('id')->on('usuarios');
            $table->foreign('id_tipo_retiro_b3')->references('id')->on('tipo_retiro_b3');
            $table->foreign('id_bodega_b3')->references('id')->on('bodega_ubicacion_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_bodega_b3');
    }
}

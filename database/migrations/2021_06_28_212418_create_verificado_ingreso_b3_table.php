<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificadoIngresoB3Table extends Migration
{
    /**
     * Por cada verificacion se debe llevar un detalle
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificado_ingreso_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();

            // usuario
            $table->bigInteger('id_usuarios')->unsigned();

            // ubicacion de bodega donde se verifica el ingreso
            $table->bigInteger('id_bodega_ubicacion_b3')->unsigned();
            $table->dateTime('fecha');

            // nota opcional
            $table->string('nota', 200)->nullable();

            $table->foreign('id_ingresos_b3')->references('id')->on('ingresos_b3');
            $table->foreign('id_bodega_ubicacion_b3')->references('id')->on('bodega_ubicacion_b3');
            $table->foreign('id_usuarios')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verificado_ingreso_b3');
    }
}

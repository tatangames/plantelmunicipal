<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosB3Table extends Migration
{
    /**
     * Sistema para bodega Bienes Municipales
     * se registra el proyecto nuevo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuarios')->unsigned();
            // esto identifica si es proyecto o es otra cosa
            $table->bigInteger('id_servicios')->unsigned();
            // estado del proyecto
            $table->bigInteger('id_estado_proyecto_b3')->unsigned();

            // nombre del proyecto
            $table->string('nombre', 800);

            // destino del proyecto
            $table->string('destino', 800)->nullable();

            // notas generales
            $table->string('nota', 300)->nullable();

            // codigo para este ingreso
            $table->string('codigo', 150)->nullable();

            // fecha creacion
            $table->dateTime('fecha');

            // fecha de termiando
            $table->dateTime('fecha_terminado')->nullable();

            $table->foreign('id_usuarios')->references('id')->on('usuarios');
            $table->foreign('id_servicios')->references('id')->on('servicios_b3');
            $table->foreign('id_estado_proyecto_b3')->references('id')->on('estados_proyecto_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_b3');
    }
}

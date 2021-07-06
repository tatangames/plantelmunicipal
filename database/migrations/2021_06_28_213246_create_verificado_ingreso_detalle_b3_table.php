<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificadoIngresoDetalleB3Table extends Migration
{
    /**
     * Por cada verificacion se debe llevar un detalle
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificado_ingreso_detalle_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_verificado_ingreso_b3')->unsigned();
            $table->bigInteger('id_ingresos_detalle_b3')->unsigned();
            $table->integer('cantidad');

            $table->foreign('id_verificado_ingreso_b3')->references('id')->on('verificado_ingreso_b3');
            $table->foreign('id_ingresos_detalle_b3')->references('id')->on('ingresos_detalle_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verificado_ingreso_detalle_b3');
    }
}

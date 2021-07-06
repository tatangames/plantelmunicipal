<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroBodegaDetalleB3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_bodega_detalle_b3', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('id_retiro_bodega_b3')->unsigned();
            $table->bigInteger('id_ingresos_detalle_b3')->unsigned();

            // cantidad a retirar
            $table->integer('cantidad');

            $table->foreign('id_retiro_bodega_b3')->references('id')->on('retiro_bodega_b3');
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
        Schema::dropIfExists('retiro_bodega_detalle_b3');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroBodegaDetalleB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_bodega_detalle_b1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_retiro_bodega')->unsigned();

            // nombre del material, repuesto, u otro.
            $table->bigInteger('id_registro_bodega')->unsigned();

            // cantidad a retirar
            $table->integer('cantidad');

            // para cualquier problema que haya en el repuesto a dar
            $table->string('descripcion', 500)->nullable();

            $table->foreign('id_retiro_bodega')->references('id')->on('retiro_bodega_b1');
            $table->foreign('id_registro_bodega')->references('id')->on('registro_bodega_b1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_bodega_detalle_b1');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiroBodegaDetalleB4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retiro_bodega_detalle_b4', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_retiro_bodega_b4')->unsigned();

            // nombre del material, repuesto, u otro.
            $table->bigInteger('id_registro_bodega_b4')->unsigned();

            // cantidad a retirar
            $table->integer('cantidad');

            // para cualquier problema que haya en el repuesto a dar
            $table->string('descripcion', 500)->nullable();

            $table->foreign('id_retiro_bodega_b4')->references('id')->on('retiro_bodega_b4');
            $table->foreign('id_registro_bodega_b4')->references('id')->on('registro_bodega_b4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retiro_bodega_detalle_b4');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosDetalleB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle_b1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos')->unsigned();
            $table->bigInteger('id_unidadmedida')->unsigned();

            // nombre del material, repuesto, u otro.
            $table->bigInteger('id_registro_bodega')->unsigned();

            $table->string('descripcion', 300)->nullable();
            $table->integer('cantidad');
            $table->decimal('preciounitario', 10,2);

            $table->foreign('id_ingresos')->references('id')->on('ingresos_b1');
            $table->foreign('id_unidadmedida')->references('id')->on('unidad_medida_b1');
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
        Schema::dropIfExists('ingresos_detalle_b1');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosDetalleB4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle_b4', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b4')->unsigned();
            $table->bigInteger('id_registro_bodega_b4')->unsigned();

            $table->string('descripcion', 300)->nullable();
            $table->integer('cantidad');
            $table->decimal('preciounitario', 10,2);

            $table->foreign('id_ingresos_b4')->references('id')->on('ingresos_b4');
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
        Schema::dropIfExists('ingresos_detalle_b4');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosDetalleB3Table extends Migration
{
    /**
     * Sistema para bodega Bienes Municipales
     * se registra el detalle del proyecto - ingreso
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();

            $table->string('nombre', 300);
            $table->integer('cantidad');
            $table->decimal('preciounitario', 10,2);

            $table->foreign('id_ingresos_b3')->references('id')->on('ingresos_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_detalle_b3');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosDetalleB2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle_b2', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b2')->unsigned();

            $table->string('nombre', 300);
            $table->string('codigo', 30)->nullable();
            $table->decimal('cantidad', 10, 2);
            $table->decimal('preciounitario', 10,2);

            $table->foreign('id_ingresos_b2')->references('id')->on('ingresos_b2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_detalle_b2');
    }
}

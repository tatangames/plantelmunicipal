<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosEncargadoB3Table extends Migration
{
    /**
     * Se registra el ID ingreso
     * y se registran a todos los encargados
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_encargado_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();
            $table->bigInteger('id_cargos_b3')->unsigned();
            $table->bigInteger('id_encargados_b3')->unsigned();

            $table->foreign('id_ingresos_b3')->references('id')->on('ingresos_b3');
            $table->foreign('id_cargos_b3')->references('id')->on('cargos_b3');
            $table->foreign('id_encargados_b3')->references('id')->on('encargados_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_encargado_b3');
    }
}

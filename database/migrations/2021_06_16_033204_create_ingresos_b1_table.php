<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_b1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_proveedor')->unsigned();
            $table->bigInteger('id_tipomaterial')->unsigned();
            $table->bigInteger('id_tipoingreso')->unsigned();
            $table->bigInteger('id_usuarios')->unsigned();
            $table->bigInteger('id_equipo')->unsigned();
            $table->dateTime('fecha');

            $table->foreign('id_proveedor')->references('id')->on('proveedores_b1');
            $table->foreign('id_tipomaterial')->references('id')->on('tipos_b1');
            $table->foreign('id_tipoingreso')->references('id')->on('condicion_b1');
            $table->foreign('id_usuarios')->references('id')->on('usuarios');
            $table->foreign('id_equipo')->references('id')->on('equipos_b1');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_b1');
    }
}

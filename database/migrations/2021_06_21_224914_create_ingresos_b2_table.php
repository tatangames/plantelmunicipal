<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosB2Table extends Migration
{
    /**
     * Sistema para marlene - Registrar compras para cada equipo
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_b2', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuarios')->unsigned();
            $table->bigInteger('id_equipo2')->unsigned();
            $table->dateTime('fecha');
            $table->string('nota', 400)->nullable();

            $table->foreign('id_usuarios')->references('id')->on('usuarios');
            $table->foreign('id_equipo2')->references('id')->on('equipos_b2');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_b2');
    }
}

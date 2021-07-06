<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroExtraMaterialB3Table extends Migration
{
    /**
     * cuando se ingresa un material extra a un proyecto
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_extra_material_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();
            $table->string('nota', 500)->nullable();
            $table->dateTime('fecha');

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
        Schema::dropIfExists('registro_extra_material_b3');
    }
}

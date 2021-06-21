<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegaNumeracionB1Table extends Migration
{
    /**
     * Identificacion de la Bodega 1
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_numeracion_b1', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->unique();
            $table->string('descripcion', 300)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodega_numeracion_b1');
    }
}

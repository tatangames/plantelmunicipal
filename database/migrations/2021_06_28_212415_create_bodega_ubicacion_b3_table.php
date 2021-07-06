<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegaUbicacionB3Table extends Migration
{
    /**
     * Registro de bodegas donde se recibe el material
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodega_ubicacion_b3', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodega_ubicacion_b3');
    }
}

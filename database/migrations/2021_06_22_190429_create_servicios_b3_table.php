<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosB3Table extends Migration
{
    /**
     * Sistema para bodega Bienes Municipales
     * se registran por proyectos, etc.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_b3', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios_b3');
    }
}

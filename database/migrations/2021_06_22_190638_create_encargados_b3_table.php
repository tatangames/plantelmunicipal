<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncargadosB3Table extends Migration
{
    /**
     * Sistema para bodega Bienes Municipales
     * nombre de los encargados
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargados_b3', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->boolean('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encargados_b3');
    }
}

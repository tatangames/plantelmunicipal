<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoRetiroB3Table extends Migration
{
    /**
     * Tipos de retiro que se hacen
     * retiro
     * donacion
     * etc
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_retiro_b3', function (Blueprint $table) {
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
        Schema::dropIfExists('tipo_retiro_b3');
    }
}

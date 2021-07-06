<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargosB3Table extends Migration
{
    /**
     * Diferentes cargos (Encargado, supervisor, etc)
     *
     * @return void
     */
    public function up(){
        Schema::create('cargos_b3', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cargos_b3');
    }
}

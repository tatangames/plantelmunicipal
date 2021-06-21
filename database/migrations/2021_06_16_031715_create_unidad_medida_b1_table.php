<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadMedidaB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_medida_b1', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('magnitud', 50);
            $table->string('simbolo', 50);
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
        Schema::dropIfExists('unidad_medida_b1');
    }
}

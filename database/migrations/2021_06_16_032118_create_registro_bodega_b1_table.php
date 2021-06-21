<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroBodegaB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_bodega_b1', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bodega_num')->unsigned();
            $table->string('nombre', 300)->unique();
            $table->string('codigo', 50)->nullable();

            $table->foreign('id_bodega_num')->references('id')->on('bodega_numeracion_b1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_bodega_b1');
    }
}

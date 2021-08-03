<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosB4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_b4', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_proveedor_b4')->unsigned();
            $table->bigInteger('id_usuarios')->unsigned();
            $table->dateTime('fecha');
            $table->string('nota', 300)->nullable();

            $table->foreign('id_proveedor_b4')->references('id')->on('proveedores_b4');
            $table->foreign('id_usuarios')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_b4');
    }
}

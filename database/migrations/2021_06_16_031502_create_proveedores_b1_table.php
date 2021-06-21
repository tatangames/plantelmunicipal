<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresB1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_b1', function (Blueprint $table) {
            $table->id();
            $table->string('empresa', 150);
            $table->string('nombrecontacto', 100)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('observaciones', 300)->nullable();
            $table->string('telfijo', 10)->nullable();
            $table->string('telmovil', 10)->nullable();
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
        Schema::dropIfExists('proveedores_b1');
    }
}

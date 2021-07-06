<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentoIngresoB3Table extends Migration
{
    /**
     * Se guardan los documentos de los ingresos_b3
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_ingreso_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ingresos_b3')->unsigned();
            $table->string('nombre', 100)->nullable();
            $table->string('urldoc', 100);

            $table->foreign('id_ingresos_b3')->references('id')->on('ingresos_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documento_ingreso_b3');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisExMateDetaB3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regis_ex_mate_deta_b3', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_reg_ex_mate_b3')->unsigned();
            $table->bigInteger('id_ingresos_detalle_b3')->unsigned();

            $table->foreign('id_reg_ex_mate_b3')->references('id')->on('registro_extra_material_b3');
            $table->foreign('id_ingresos_detalle_b3')->references('id')->on('ingresos_detalle_b3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regis_ex_mate_deta_b3');
    }
}

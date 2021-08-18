<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProveedorToIngresosB2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingresos_b2', function (Blueprint $table) {
            $table->bigInteger('proveedorb2_id')->unsigned()->default(1);

            $table->foreign('proveedorb2_id')->references('id')->on('proveedores_b2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ingresos_b2', function (Blueprint $table) {
            $table->dropColumn(['proveedorb2_id']);
        });
    }
}

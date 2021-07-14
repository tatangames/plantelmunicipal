<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsuarioToRegistroExtraMaterialB3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registro_extra_material_b3', function (Blueprint $table) {
            $table->bigInteger('id_usuarios')->unsigned();

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
        Schema::table('registro_extra_material_b3', function (Blueprint $table) {
            $table->dropColumn(['id_usuarios']);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->string('tienda');
            $table->timestamp('fechaInicial');
            $table->timestamp('fechaFinal');
            $table->integer('registrosObtenidos');
            $table->integer('registrosGuardados');
            $table->integer('exito');
            $table->timestamp('fechaInicioProceso');
            $table->timestamp('fechaFinProceso');
            $table->string('mensaje');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}

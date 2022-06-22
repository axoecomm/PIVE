<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosMasterdataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados_masterdata', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nombre')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('clusterId')->nullable();
            $table->string('tienda');
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('empleados_masterdata');
    }
}

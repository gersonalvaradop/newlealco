<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
             $table->string('codigo')->default("");
             $table->string('nombre')->default("");
             $table->string('nit')->default("");
             $table->string('nrc')->default("");
             $table->string('telefono')->default("");
             $table->string('dui')->default("");
             $table->string('correo')->default("");
             $table->string('nombre_contacto')->default("");
             $table->string('telefono_contacto')->default("");
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
        Schema::dropIfExists('proveedores');
    }
}

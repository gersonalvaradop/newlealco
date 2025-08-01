<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nit');
            $table->string('contacto');
            $table->datetime('fecha')->nullable();
            $table->string('token');
            $table->datetime('fecha_vencimiento')->nullable();
            $table->string('status');
            $table->string('respuesta');
            $table->longText('logo')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('companies');
    }
}

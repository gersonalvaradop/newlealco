<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('cod_gen_dte');
            $table->string('nombre');
            $table->string('correo');
            $table->string('comercial');
            $table->string('valor');
            $table->string('pdf');
            $table->integer('correo_enviado')->default(0);
            $table->text('json_data')->default('');
            $table->string('tipo_dte')->default('05');
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
        Schema::dropIfExists('registros');
    }
}

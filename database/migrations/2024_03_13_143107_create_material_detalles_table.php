<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_detalles', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad')->default(0);
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')->references('id')->on('materiales');
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
        Schema::dropIfExists('material_detalles');
    }
}

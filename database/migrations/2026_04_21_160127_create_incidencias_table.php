<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aviso_id');
            $table->string('estado')->default('pendiente');
            $table->timestamps();

            $table->foreign('aviso_id')
                ->references('id')
                ->on('avisos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('incidencias');
    }
};
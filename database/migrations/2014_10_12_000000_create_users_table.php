<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();

            $table->string('nombre'); // 🔥 CAMBIO CLAVE
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['admin', 'tecnico', 'particular'])->default('particular');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
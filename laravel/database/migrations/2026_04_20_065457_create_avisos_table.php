<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->string('tipo_servicio', 100)->nullable();
            $table->enum('urgencia', ['estandar', 'urgente'])->default('estandar');
            $table->datetime('fecha')->nullable();
            $table->string('franja', 50)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->enum('estado', ['pendiente', 'asignada', 'completada', 'cancelada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('avisos');
    }
};
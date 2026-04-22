<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->unsignedBigInteger('usuario_id');
            $table->text('descripcion');
            $table->enum('tipo_servicio', ['estandar', 'urgente'])->default('estandar');
            $table->enum('estado', ['pendiente', 'asignada', 'en_proceso', 'completada', 'cancelada'])->default('pendiente');
            $table->dateTime('fecha_servicio');
            $table->unsignedBigInteger('tecnico_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
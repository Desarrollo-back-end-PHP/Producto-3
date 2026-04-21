<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('incidencias', function (Blueprint $table) {

            if (!Schema::hasColumn('incidencias', 'localizador')) {
                $table->string('localizador')->unique()->after('id');
            }

            if (!Schema::hasColumn('incidencias', 'cliente_id')) {
                $table->foreignId('cliente_id')->constrained('usuarios');
            }

            if (!Schema::hasColumn('incidencias', 'tecnico_id')) {
                $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos');
            }

            if (!Schema::hasColumn('incidencias', 'especialidad_id')) {
                $table->foreignId('especialidad_id')->constrained('especialidades');
            }

            if (!Schema::hasColumn('incidencias', 'fecha_servicio')) {
                $table->dateTime('fecha_servicio');
            }

            if (!Schema::hasColumn('incidencias', 'tipo_urgencia')) {
                $table->enum('tipo_urgencia', ['Estándar', 'Urgente'])->default('Estándar');
            }

            if (!Schema::hasColumn('incidencias', 'estado')) {
                $table->enum('estado', ['Pendiente', 'Asignada', 'Finalizada', 'Cancelada'])->default('Pendiente');
            }

        });
    }

    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            // opcional
        });
    }
};
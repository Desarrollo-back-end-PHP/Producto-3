<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tecnicos', function (Blueprint $table) {

            if (!Schema::hasColumn('tecnicos', 'usuario_id')) {
                $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->nullOnDelete();
            }

            if (!Schema::hasColumn('tecnicos', 'especialidad_id')) {
                $table->foreignId('especialidad_id')->nullable()->constrained('especialidades');
            }

            if (!Schema::hasColumn('tecnicos', 'disponible')) {
                $table->boolean('disponible')->default(true);
            }

        });
    }

    public function down()
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            // opcional
        });
    }
};
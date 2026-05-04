<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Actualizar el ENUM de estado para incluir todos los valores que usa la app
        DB::statement("ALTER TABLE avisos MODIFY COLUMN estado ENUM('pendiente','asignada','en_proceso','finalizado','cancelada') NOT NULL DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        // Revertir al ENUM original
        DB::statement("ALTER TABLE avisos MODIFY COLUMN estado ENUM('pendiente','asignada','completada','cancelada') NOT NULL DEFAULT 'pendiente'");
    }
};

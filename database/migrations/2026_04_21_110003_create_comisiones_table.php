<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();

            // 🔥 RELACIÓN CORRECTA
            $table->foreignId('usuario_id')
                  ->constrained('usuarios')
                  ->onDelete('cascade');

            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comisiones');
    }
};
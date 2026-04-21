<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('comisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aviso_id')->constrained('avisos')->onDelete('cascade');
            $table->foreignId('gestora_id')->nullable()->constrained('gestoras')->nullOnDelete();
            $table->decimal('importe', 8, 2)->default(0);
            $table->decimal('porcentaje', 5, 2)->default(5.00);
            $table->integer('mes');
            $table->integer('anyo');
            $table->enum('estado', ['pendiente', 'liquidada'])->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('comisions');
    }
};
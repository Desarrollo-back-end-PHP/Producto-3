<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('rol');
            $table->unsignedBigInteger('especialidad_id')->nullable()->after('telefono');
            $table->boolean('activo')->default(1)->after('especialidad_id');

            $table->foreign('especialidad_id')
                  ->references('id')
                  ->on('especialidades')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['especialidad_id']);
            $table->dropColumn(['telefono', 'especialidad_id', 'activo']);
        });
    }
};

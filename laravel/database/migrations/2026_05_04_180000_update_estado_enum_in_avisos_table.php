<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // SQLite no soporta MODIFY COLUMN
    }

    public function down(): void
    {
        // SQLite no soporta MODIFY COLUMN
    }
};
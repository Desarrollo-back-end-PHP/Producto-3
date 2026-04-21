<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE usuarios 
            MODIFY rol ENUM('admin', 'tecnico', 'particular', 'gestora') 
            NOT NULL DEFAULT 'particular'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE usuarios 
            MODIFY rol ENUM('admin', 'tecnico', 'particular') 
            NOT NULL DEFAULT 'particular'
        ");
    }
};
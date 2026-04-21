<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Evitar duplicados
        if (!Usuario::where('email', 'admin@admin.com')->exists()) {

            Usuario::create([
                'nombre' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => bcrypt('123456'),
                'rol' => 'admin'
            ]);
        }
    }
}
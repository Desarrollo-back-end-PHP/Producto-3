<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidad;

class EspecialidadesSeeder extends Seeder
{
    public function run(): void
    {
        $especialidades = [
            'Fontanería',
            'Electricidad',
            'Aire acondicionado',
            'Electrodomésticos',
            'Cerrajería',
            'Ascensores',
            'Pintura e impermeabilización',
            'Albañilería',
            'Carpintería',
            'Jardinería',
            
        ];

        foreach ($especialidades as $nombre) {
            Especialidad::create([
                'nombre' => $nombre
            ]);
        }
    }
}
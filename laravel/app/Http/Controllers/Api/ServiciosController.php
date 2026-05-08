<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aviso;

class ServiciosController extends Controller
{
    public function zonas()
    {
        $total = Aviso::count();

        $zonas = Aviso::selectRaw('zona, COUNT(*) as total_servicios')
            ->groupBy('zona')
            ->get()
            ->map(function ($zona) use ($total) {
                return [
                    'zona' => $zona->zona,
                    'total_servicios' => $zona->total_servicios,
                    'porcentaje' => $total > 0 
                        ? round(($zona->total_servicios / $total) * 100, 2)
                        : 0
                ];
            });

        return response()->json($zonas);
    }
}
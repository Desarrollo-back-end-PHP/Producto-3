<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aviso;

class ServiciosController extends Controller
{
    public function zonas()
    {
        // Solo contamos servicios realizados (finalizados)
        $total = Aviso::where('estado', 'finalizado')->count();

        $zonas = Aviso::where('estado', 'finalizado')
            ->whereNotNull('zona')
            ->selectRaw('zona, COUNT(*) as total_servicios')
            ->groupBy('zona')
            ->orderBy('total_servicios', 'desc')
            ->get()
            ->map(function ($item) use ($total) {
                return [
                    'zona'             => $item->zona,
                    'total_servicios'  => $item->total_servicios,
                    'porcentaje'       => $total > 0
                        ? round(($item->total_servicios / $total) * 100, 2)
                        : 0,
                ];
            });

        return response()->json([
            'total_global' => $total,
            'zonas'        => $zonas,
        ]);
    }
}
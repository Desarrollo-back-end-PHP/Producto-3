<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aviso;
use App\Models\Especialidad;

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

    public function avisos()
    {
        $avisos = Aviso::where('estado', 'finalizado')
            ->with('especialidad')
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(function ($aviso) {
                return [
                    'codigo'       => $aviso->codigo,
                    'fecha'        => $aviso->fecha ? $aviso->fecha->format('d/m/Y') : null,
                    'zona'         => $aviso->zona,
                    'urgencia'     => $aviso->urgencia,
                    'estado'       => $aviso->estado,
                    'especialidad' => $aviso->especialidad ? $aviso->especialidad->nombre : null,
                    'descripcion'  => $aviso->descripcion,
                    'precio'       => $aviso->precio,
                ];
            });

        return response()->json([
            'total'  => $avisos->count(),
            'avisos' => $avisos,
        ]);
    }
}
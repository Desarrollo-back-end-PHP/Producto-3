<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Comision;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    // formatter en_proceso
    private function formatearEstado(string $estado): string
    {
        return ucfirst(str_replace('_', ' ', $estado));
    }

    // PANEL TECNICO
    public function index()
    {
        $tecnicoId = auth()->id();

        $avisos = Aviso::where('tecnico_id', $tecnicoId)
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha', 'desc')
            ->get();

        $notificaciones = Notificacion::where('user_id', $tecnicoId)
            ->latest()
            ->get();

        return view('tecnico.panel', compact('avisos', 'notificaciones'));
    }

    // CAMBIAR ESTADO DE UN AVISO
    public function cambiarEstado(Request $request)
    {
        $aviso = Aviso::findOrFail($request->aviso_id);

        // Un técnico solo puede cambiar el estado de sus propios avisos
        if ($aviso->tecnico_id !== auth()->id()) {
            abort(403);
        }

        $estadoAnterior = $aviso->estado;
        $aviso->update(['estado' => $request->estado]);

        // Notificar a la gestora si el estado cambia
        if ($estadoAnterior !== $request->estado && $aviso->gestora_id) {
            Notificacion::create([
                'user_id' => $aviso->gestora_id,
                'mensaje' => "El aviso {$aviso->codigo} cambió a {$this->formatearEstado($request->estado)}",
                'leida'   => 0,
            ]);
        }

        // Genero comisión al marcar como finalizado
        if ($estadoAnterior !== 'finalizado' && $request->estado === 'finalizado' && $aviso->gestora_id) {
            if (!Comision::where('aviso_id', $aviso->id)->exists()) {
                $precioBase = $aviso->precio ?? 100;
                $porcentaje = 10;

                Comision::create([
                    'aviso_id'   => $aviso->id,
                    'gestora_id' => $aviso->gestora_id,
                    'importe'    => ($precioBase * $porcentaje) / 100,
                    'porcentaje' => $porcentaje,
                    'mes'        => now()->month,
                    'anyo'       => now()->year,
                    'estado'     => 'pendiente',
                ]);
            }
        }

        return back()->with('success', 'Estado actualizado.');
    }
}

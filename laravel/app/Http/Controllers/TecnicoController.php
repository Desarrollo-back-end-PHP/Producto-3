<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Comision;

class TecnicoController extends Controller
{
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

    public function cambiarEstado(Request $request)
    {
        $aviso = Aviso::findOrFail($request->aviso_id);

        // 🔒 Seguridad
        if ($aviso->tecnico_id !== auth()->id()) {
            abort(403);
        }

        $estadoAnterior = $aviso->estado;

        $aviso->update([
            'estado' => $request->estado
        ]);

        // 🔔 NOTIFICAR A GESTORA
        if ($estadoAnterior !== $request->estado && $aviso->gestora_id) {
            Notificacion::create([
                'user_id' => $aviso->gestora_id,
                'mensaje' => "El aviso {$aviso->codigo} cambió a {$request->estado}",
                'leida' => 0
            ]);
        }

        // 💰 GENERAR COMISIÓN
        if ($estadoAnterior !== 'finalizado' && $request->estado === 'finalizado') {

            if ($aviso->gestora_id) {

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

        return back()->with('success', 'Estado actualizado');
    }
}
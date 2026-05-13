<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Http\Requests\NuevaSolicitudRequest;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::where('usuario_id', Auth::id())
            ->orderBy('fecha_creacion', 'desc')
            ->get();
        return view('incidencias.index', compact('incidencias'));
    }

    public function create()
    {
        return view('incidencias.create');
    }

    public function store(NuevaSolicitudRequest $request)
    {
        $incidencia = Incidencia::create([
            'codigo'         => 'INC-' . strtoupper(uniqid()),
            'usuario_id'     => Auth::id(),
            'descripcion'    => $request->descripcion,
            'tipo_servicio'  => $request->tipo_servicio,
            'fecha_servicio' => $request->fecha_servicio,
            'estado'         => 'pendiente',
        ]);

        \App\Models\Aviso::create([
            'codigo'      => $incidencia->codigo,
            'usuario_id'  => Auth::id(),
            'urgencia'    => $request->tipo_servicio,
            'fecha'       => $request->fecha_servicio,
            'descripcion' => $request->descripcion,
            'estado'      => 'pendiente',
        ]);

        return redirect()->route('incidencias.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

    public function destroy($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        if ($incidencia->usuario_id !== Auth::id()) {
            abort(403);
        }
        $incidencia->delete();
        return back()->with('success', 'Solicitud cancelada.');
    }
}
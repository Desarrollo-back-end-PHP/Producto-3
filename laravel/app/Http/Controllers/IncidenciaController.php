<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Http\Requests\NuevaSolicitudRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    // Listado "Mis Avisos"
    public function index()
    {
        $incidencias = Incidencia::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.mis_avisos', compact('incidencias'));
    }

    // Formulario nueva solicitud
    public function create()
    {
        return view('cliente.nueva_solicitud');
    }

    // Guardar nueva solicitud
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

        return redirect()->route('incidencias.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

    // Cancelar incidencia
    public function destroy($id)
    {
        $incidencia = Incidencia::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        $horasRestantes = Carbon::now()->diffInHours(
            Carbon::parse($incidencia->fecha_servicio), false
        );

        if ($horasRestantes < 48) {
            return redirect()->route('incidencias.index')
                ->with('error', 'No puedes cancelar una incidencia con menos de 48 horas de antelación.');
        }

        $incidencia->update(['estado' => 'cancelada']);

        return redirect()->route('incidencias.index')
            ->with('success', 'Incidencia cancelada correctamente.');
    }
}
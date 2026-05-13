<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\Aviso;
use App\Models\Especialidad;
use App\Http\Requests\NuevaSolicitudRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('cliente.mis_avisos', compact('incidencias'));
    }

    public function create()
    {
        $especialidades = Especialidad::orderBy('nombre')->get();
        return view('cliente.nueva_solicitud', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion'    => 'required',
            'tipo_servicio'  => 'required|in:estandar,urgente',
            'fecha_servicio' => 'required|date|after:now',
            'direccion'      => 'required',
            'telefono'       => 'required',
        ]);

        $codigo = 'INC-' . strtoupper(uniqid());

        // Crear incidencia del cliente
        Incidencia::create([
            'codigo'         => $codigo,
            'usuario_id'     => Auth::id(),
            'descripcion'    => $request->descripcion,
            'tipo_servicio'  => $request->tipo_servicio,
            'fecha_servicio' => $request->fecha_servicio,
            'estado'         => 'pendiente',
        ]);

        // Crear aviso visible para todos los roles
        Aviso::create([
            'codigo'          => $codigo,
            'usuario_id'      => Auth::id(),
            'especialidad_id' => $request->especialidad_id,
            'urgencia'        => $request->tipo_servicio,
            'fecha'           => $request->fecha_servicio,
            'franja'          => $request->franja,
            'zona'            => $request->zona,
            'precio'          => $request->precio ?? 100,
            'descripcion'     => $request->descripcion,
            'direccion'       => $request->direccion,
            'telefono'        => $request->telefono,
            'estado'          => 'pendiente',
        ]);

        return redirect()->route('incidencias.index')
            ->with('success', 'Solicitud creada correctamente.');
    }

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

        // Cancelar también el aviso correspondiente
        Aviso::where('codigo', $incidencia->codigo)->update(['estado' => 'cancelada']);

        return redirect()->route('incidencias.index')
            ->with('success', 'Incidencia cancelada correctamente.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Comision;
use App\Models\User;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class GestoraController extends Controller
{
    // =========================
    // PANEL GESTORA
    // =========================
    public function index()
    {
        $gestoraId = auth()->id();

        // Avisos de esta gestora
        $avisos = Aviso::where('gestora_id', $gestoraId)
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha', 'desc')
            ->get();

        // Comisiones agrupadas mes a mes
        $comisiones = Comision::where('gestora_id', $gestoraId)
            ->selectRaw('mes, anyo, estado, SUM(importe) as total')
            ->groupBy('mes', 'anyo', 'estado')
            ->orderBy('anyo', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        // técnicos activos 
        $tecnicos = User::where('rol', 'tecnico')->where('activo', 1)->get();

        // Especialidades para el select
        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('gestora.panel', compact(
            'avisos',
            'comisiones',
            'tecnicos',
            'especialidades'
        ));
    }

    // =========================
    // CREAR AVISO
    // =========================
    public function crear(Request $request)
    {
        $request->validate([
            'especialidad_id' => 'required',
            'urgencia'        => 'required',
            'fecha'           => 'required|date',
            'descripcion'     => 'required',
            'direccion'       => 'required',
            'telefono'        => 'required',
        ]);

        Aviso::create([
            'codigo'          => Aviso::generarCodigo(),
            'especialidad_id' => $request->especialidad_id,
            'urgencia'        => $request->urgencia,
            'fecha'           => $request->fecha,
            'franja'          => $request->franja,
            'zona'            => $request->zona,
            'precio'          => $request->precio ?? 100,
            'descripcion'     => $request->descripcion,
            'direccion'       => $request->direccion,
            'telefono'        => $request->telefono,
            'estado'          => 'pendiente',
            'gestora_id'      => auth()->id(),
        ]);

        return redirect()->route('gestora.panel')
            ->with('success', 'Aviso creado correctamente.');
    }

    // =========================
    // CANCELAR AVISO PROPIO
    // =========================
    public function cancelarAviso($id)
    {
        // Solo puede cancelar sus propios avisos
        $aviso = Aviso::where('id', $id)
            ->where('gestora_id', auth()->id())
            ->firstOrFail();

        if ($aviso->estado === 'finalizado') {
            return back()->with('error', 'No se puede cancelar un aviso finalizado.');
        }

        $aviso->update(['estado' => 'cancelada']);

        return back()->with('success', 'Aviso cancelado.');
    }
}

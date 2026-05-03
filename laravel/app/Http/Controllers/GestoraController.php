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

        // Comisiones agrupadas
        $comisiones = Comision::where('gestora_id', $gestoraId)
            ->where('estado', 'pendiente')
            ->selectRaw('mes, anyo, SUM(importe) as total')
            ->groupBy('mes', 'anyo')
            ->orderBy('anyo', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        // Técnicos disponibles
        $tecnicos = User::where('rol', 'tecnico')->get();

        // 🔥 CLAVE: especialidades para el select
        $especialidades = Especialidad::all();

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
            'especialidad_id' => $request->especialidad_id, // 🔥 importante
            'urgencia'        => $request->urgencia,
            'fecha'           => $request->fecha,
            'franja'          => $request->franja,
            'zona'            => $request->zona,
            'descripcion'     => $request->descripcion,
            'direccion'       => $request->direccion,
            'telefono'        => $request->telefono,
            'estado'          => 'pendiente',
            'gestora_id'      => auth()->id(),
        ]);

        return redirect()->route('gestora.panel')
            ->with('success', 'Aviso creado correctamente');
    }
}
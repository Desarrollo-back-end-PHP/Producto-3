<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Comision;
use Illuminate\Http\Request;

class AdminController extends Controller {

    // Panel principal - listado de avisos
    public function index() {
        $avisos = Aviso::with('tecnico')->where('estado', '!=', 'cancelada')->orderBy('fecha', 'desc')->get();
        $tecnicos = \App\Models\Tecnico::all();
        return view('admin.panel', compact('avisos', 'tecnicos'));
    }

    // Crear aviso
    public function crear(Request $request) {
        $request->validate([
            'tipo_servicio' => 'required|string|max:100',
            'urgencia'      => 'required|in:estandar,urgente',
            'fecha'         => 'required|date',
            'descripcion'   => 'required|string',
            'direccion'     => 'required|string|max:255',
            'telefono'      => 'required|string|max:20',
        ]);

        Aviso::create([
            'codigo'        => Aviso::generarCodigo(),
            'tipo_servicio' => $request->tipo_servicio,
            'urgencia'      => $request->urgencia,
            'fecha'         => $request->fecha,
            'franja'        => $request->franja,
            'descripcion'   => $request->descripcion,
            'direccion'     => $request->direccion,
            'telefono'      => $request->telefono,
            'estado'        => 'pendiente',
        ]);

        return redirect()->route('admin.panel')->with('success', 'Aviso creado correctamente.');
    }

    // Editar aviso
    public function editar($id) {
        $aviso = Aviso::findOrFail($id);
        return view('admin.detalle_aviso', compact('aviso'));
    }

    // Actualizar aviso
    public function actualizar(Request $request, $id) {
        $aviso = Aviso::findOrFail($id);
        $aviso->update($request->only([
            'tipo_servicio', 'urgencia', 'fecha', 'franja',
            'descripcion', 'direccion', 'telefono'
        ]));
        return redirect()->route('admin.panel')->with('success', 'Aviso actualizado correctamente.');
    }

    // Cancelar aviso
    public function cancelar($id) {
        $aviso = Aviso::findOrFail($id);
        $aviso->update(['estado' => 'cancelada']);
        return redirect()->route('admin.panel')->with('success', 'Aviso cancelado.');
    }

    // Asignar técnico
    public function asignarTecnico(Request $request) {
        $aviso = Aviso::findOrFail($request->aviso_id);
        $aviso->update(['tecnico_id' => $request->tecnico_id]);
        return redirect()->route('admin.panel')->with('success', 'Tecnico asignado correctamente.');
    }

    // Calendario
    public function calendario() {
        $avisos = Aviso::where('estado', '!=', 'cancelada')->get();
        return view('admin.calendario', compact('avisos'));
    }

    // Liquidaciones por gestora
    public function liquidaciones() {
        $liquidaciones = Comision::with('gestora')
            ->selectRaw('gestora_id, mes, anyo, SUM(importe) as total')
            ->groupBy('gestora_id', 'mes', 'anyo')
            ->orderBy('anyo', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
        return view('admin.liquidaciones', compact('liquidaciones'));
    }
}
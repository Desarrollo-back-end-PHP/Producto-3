<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Comision;
use App\Models\User;
use App\Models\Notificacion;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class AdminController extends Controller {

    // PANEL ADMIN
    public function index() {

        $avisos = Aviso::with('especialidad')
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha', 'desc')
            ->get();

        $tecnicos = User::where('rol', 'tecnico')->get();
        $gestoras = User::where('rol', 'gestora')->get();
        $especialidades = Especialidad::all();

        return view('admin.panel', compact(
            'avisos',
            'tecnicos',
            'gestoras',
            'especialidades'
        ));
    }

    // CREAR AVISO
    public function crear(Request $request)
    {
        $request->validate([
            'especialidad_id' => 'required|exists:especialidades,id',
            'urgencia'        => 'required|in:estandar,urgente',
            'fecha'           => 'required|date',
            'descripcion'     => 'required|string',
            'direccion'       => 'required|string|max:255',
            'telefono'        => 'required|string|max:20',
        ]);

        $gestoraId = null;

        if (auth()->user()->rol === 'gestora') {
            $gestoraId = auth()->id();
        } elseif ($request->filled('gestora_id')) {
            $gestoraId = $request->gestora_id;
        }

        $aviso = Aviso::create([
            'codigo'          => Aviso::generarCodigo(),
            'especialidad_id' => $request->especialidad_id,
            'urgencia'        => $request->urgencia,
            'fecha'           => \Carbon\Carbon::parse($request->fecha),
            'franja'          => $request->franja,
            'zona'            => $request->zona,
            'precio'          => $request->precio ?? 100,
            'descripcion'     => $request->descripcion,
            'direccion'       => $request->direccion,
            'telefono'        => $request->telefono,
            'estado'          => 'pendiente',
            'gestora_id'      => $gestoraId,
            'tecnico_id'      => $request->tecnico_id,
        ]);

        // 🔔 Notificación si ya se asigna técnico al crear
        if ($request->tecnico_id) {
            Notificacion::create([
                'user_id' => $request->tecnico_id,
                'mensaje' => "Se te ha asignado el aviso {$aviso->codigo}",
                'leida'   => 0
            ]);
        }

        return redirect()->route('admin.panel')
            ->with('success', 'Aviso creado correctamente.');
    }

    // EDITAR
    public function editar($id) {
        $aviso = Aviso::findOrFail($id);
        return view('admin.detalle_aviso', compact('aviso'));
    }

    // ACTUALIZAR
    public function actualizar(Request $request, $id)
    {
        $aviso = Aviso::findOrFail($id);

        $estadoAnterior = $aviso->estado;

        $aviso->update($request->only([
            'urgencia',
            'fecha',
            'franja',
            'zona',
            'descripcion',
            'direccion',
            'telefono',
            'estado'
        ]));

        // 🔔 NOTIFICACIONES
        if ($request->estado && $estadoAnterior !== $request->estado) {

            if ($aviso->tecnico_id) {
                Notificacion::create([
                    'user_id' => $aviso->tecnico_id,
                    'mensaje' => "El aviso {$aviso->codigo} cambió a {$request->estado}",
                    'leida' => 0
                ]);
            }

            if ($aviso->gestora_id) {
                Notificacion::create([
                    'user_id' => $aviso->gestora_id,
                    'mensaje' => "El aviso {$aviso->codigo} cambió a {$request->estado}",
                    'leida' => 0
                ]);
            }
        }

        // 💰 comisión al finalizar
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

        return redirect()->route('admin.panel')
            ->with('success', 'Aviso actualizado correctamente.');
    }

    // CANCELAR
    public function cancelar($id) {

        $aviso = Aviso::findOrFail($id);

        $aviso->update([
            'estado' => 'cancelada'
        ]);

        return redirect()->route('admin.panel')
            ->with('success', 'Aviso cancelado.');
    }

    // ASIGNAR TECNICO
   public function asignarTecnico(Request $request)
{
    $aviso = Aviso::findOrFail($request->aviso_id);

    // 🔐 PROTECCIÓN PARA GESTORA
    if (auth()->user()->rol === 'gestora' && $aviso->gestora_id !== auth()->id()) {
        abort(403);
    }

    $aviso->update([
        'tecnico_id' => $request->tecnico_id
    ]);

    // 🔔 NOTIFICACIÓN
    if ($request->tecnico_id) {
        Notificacion::create([
            'user_id' => $request->tecnico_id,
            'mensaje' => "Se te ha asignado el aviso {$aviso->codigo}",
            'leida' => 0
        ]);
    }

    return back()->with('success', 'Técnico asignado correctamente.');
}

    // CALENDARIO
   public function calendario()
{
    $avisos = \App\Models\Aviso::with('especialidad')->get();

    $eventos = $avisos->map(function($a) {
        return [
            'title' => ($a->especialidad->nombre ?? 'N/A') . ' - ' . $a->codigo,
            'start' => $a->fecha,
            'color' => $a->urgencia === 'urgente' ? '#e74c3c' : '#27ae60',
            'extendedProps' => [
                'descripcion' => $a->descripcion,
                'direccion'   => $a->direccion,
                'telefono'    => $a->telefono,
                'estado'      => $a->estado,
                'urgencia'    => $a->urgencia,
            ]
        ];
    });

    return view('admin.calendario', [
        'eventos' => $eventos
    ]);
}

    // LIQUIDACIONES
    public function liquidaciones()
    {
        $liquidaciones = Comision::with('gestora')
            ->selectRaw('gestora_id, mes, anyo, estado, SUM(importe) as total')
            ->groupBy('gestora_id', 'mes', 'anyo', 'estado')
            ->orderBy('anyo', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return view('admin.liquidaciones', compact('liquidaciones'));
    }
    //Liquidar comision 
    public function liquidarComisiones(Request $request)
{
    Comision::where('gestora_id', $request->gestora_id)
        ->where('mes', $request->mes)
        ->where('anyo', $request->anyo)
        ->where('estado', 'pendiente')
        ->update([
            'estado' => 'liquidada'
        ]);

    return back()->with('success', 'Comisiones liquidadas correctamente');
}
}
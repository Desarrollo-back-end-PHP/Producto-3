<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Comision;
use App\Models\User;
use App\Models\Notificacion;
use App\Models\Especialidad;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // formatter en_proceso
    private function formatearEstado(string $estado): string
    {
        return ucfirst(str_replace('_', ' ', $estado));
    }

    // PANEL ADMIN
    public function index()
    {
        $avisos = Aviso::with(['especialidad', 'tecnico', 'gestora'])
            ->where('estado', '!=', 'cancelada')
            ->orderBy('fecha', 'desc')
            ->get();

        // Solo técnicos activos para los desplegables
        $tecnicos = User::where('rol', 'tecnico')->where('activo', 1)->get();
        $gestoras = User::where('rol', 'gestora')->get();
        $especialidades = Especialidad::orderBy('nombre')->get();

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
            'gestora_id'      => $request->gestora_id ?: null,
            'tecnico_id'      => $request->tecnico_id ?: null,
        ]);

        //  Notificación si ya se asigna técnico al crear
        if ($aviso->tecnico_id) {
            Notificacion::create([
                'user_id' => $aviso->tecnico_id,
                'mensaje' => "Se te ha asignado el aviso {$aviso->codigo}",
                'leida'   => 0,
            ]);
        }

        return redirect()->route('admin.panel')->with('success', 'Aviso creado correctamente.');
    }

    // ACTUALIZAR ESTADO Y DATOS DE UN AVISO
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
            'estado',
        ]));

        //  NOTIFICACIONES
        if ($request->estado && $estadoAnterior !== $request->estado) {
            if ($aviso->tecnico_id) {
                Notificacion::create([
                    'user_id' => $aviso->tecnico_id,
                    'mensaje' => "El aviso {$aviso->codigo} cambió a {$this->formatearEstado($request->estado)}",
                    'leida'   => 0,
                ]);
            }
            if ($aviso->gestora_id) {
                Notificacion::create([
                    'user_id' => $aviso->gestora_id,
                    'mensaje' => "El aviso {$aviso->codigo} cambió a {$this->formatearEstado($request->estado)}",
                    'leida'   => 0,
                ]);
            }
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

        return redirect()->route('admin.panel')->with('success', 'Aviso actualizado correctamente.');
    }

    // CANCELAR AVISO
    public function cancelar($id)
    {
        $aviso = Aviso::findOrFail($id);
        $aviso->update(['estado' => 'cancelada']);

        return redirect()->route('admin.panel')->with('success', 'Aviso cancelado.');
    }

    // ASIGNAR TECNICO A UN AVISO
    public function asignarTecnico(Request $request)
    {
        $aviso = Aviso::findOrFail($request->aviso_id);

        // Una gestora solo puede asignar técnicos a sus propios avisos
        if (auth()->user()->rol === 'gestora' && $aviso->gestora_id !== auth()->id()) {
            abort(403);
        }

        $aviso->update(['tecnico_id' => $request->tecnico_id]);

        if ($request->tecnico_id) {
            Notificacion::create([
                'user_id' => $request->tecnico_id,
                'mensaje' => "Se te ha asignado el aviso {$aviso->codigo}",
                'leida'   => 0,
            ]);
        }

        return back()->with('success', 'Técnico asignado correctamente.');
    }

    // CALENDARIO
    public function calendario()
    {
        $avisos = Aviso::with('especialidad')->get();

        $eventos = $avisos->map(function ($aviso) {
            return [
                'title' => ($aviso->especialidad->nombre ?? 'N/A') . ' - ' . $aviso->codigo,
                'start' => $aviso->fecha,
                'color' => $aviso->urgencia === 'urgente' ? '#e74c3c' : '#27ae60',
                'extendedProps' => [
                    'descripcion' => $aviso->descripcion,
                    'direccion'   => $aviso->direccion,
                    'telefono'    => $aviso->telefono,
                    'estado'      => $aviso->estado,
                    'urgencia'    => $aviso->urgencia,
                ],
            ];
        });

        return view('admin.calendario', ['eventos' => $eventos]);
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

    // MARCAR COMISIONES COMO LIQUIDADAS
    public function liquidarComisiones(Request $request)
    {
        Comision::where('gestora_id', $request->gestora_id)
            ->where('mes', $request->mes)
            ->where('anyo', $request->anyo)
            ->where('estado', 'pendiente')
            ->update(['estado' => 'liquidada']);

        return back()->with('success', 'Comisiones liquidadas correctamente.');
    }

    // LISTAR TECNICOS
    public function tecnicos()
    {
        $tecnicos = User::where('rol', 'tecnico')
            ->with('especialidad')
            ->orderBy('name')
            ->get();

        $especialidades = Especialidad::orderBy('nombre')->get();

        return view('admin.tecnicos.index', compact('tecnicos', 'especialidades'));
    }

    // AÑADIR TECNICO
    public function storeTecnico(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'especialidad_id' => 'nullable|exists:especialidades,id',
            'telefono'        => 'nullable|string|max:20',
            'password'        => 'required|min:6',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'password'        => Hash::make($request->password),
            'rol'             => 'tecnico',
            'telefono'        => $request->telefono,
            'especialidad_id' => $request->especialidad_id ?: null,
            'activo'          => 1,
        ]);

        return redirect()->route('admin.tecnicos')->with('success', 'Técnico añadido correctamente.');
    }

    // EDITAR TECNICO
    public function updateTecnico(Request $request, $id)
    {
        $tecnico = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email,' . $id,
            'telefono'        => 'nullable|string|max:20',
            'especialidad_id' => 'nullable|exists:especialidades,id',
            'password'        => 'nullable|min:6',
        ]);

        $data = [
            'name'            => $request->name,
            'email'           => $request->email,
            'telefono'        => $request->telefono,
            'especialidad_id' => $request->especialidad_id ?: null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $tecnico->update($data);

        return back()->with('success', 'Técnico actualizado correctamente.');
    }

    // DAR DE BAJA O REACTIVAR TECNICO
    public function darDeBaja($id)
    {
        $tecnico = User::findOrFail($id);
        $nuevoEstado = $tecnico->activo ? 0 : 1;
        $tecnico->update(['activo' => $nuevoEstado]);

        $mensaje = $nuevoEstado ? 'Técnico reactivado.' : 'Técnico dado de baja.';
        return back()->with('success', $mensaje);
    }
}

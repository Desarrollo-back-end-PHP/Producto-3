<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::orderBy('nombre')->get();
        return view('admin.servicios.index', compact('especialidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:especialidades,nombre',
        ]);

        Especialidad::create(['nombre' => $request->nombre]);

        return back()->with('success', 'Tipo de servicio añadido correctamente.');
    }

    public function update(Request $request, $id)
    {
        $especialidad = Especialidad::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:especialidades,nombre,' . $id,
        ]);

        $especialidad->update(['nombre' => $request->nombre]);

        return back()->with('success', 'Tipo de servicio actualizado.');
    }

    public function destroy($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete();

        return back()->with('success', 'Tipo de servicio eliminado.');
    }

    // Guardar varios a la vez O eliminar los seleccionados
    public function bulk(Request $request)
    {
        if ($request->action === 'delete') {
            // Eliminar los que tienen checkbox marcado
            $ids = $request->input('delete', []);
            if (!empty($ids)) {
                Especialidad::whereIn('id', $ids)->delete();
                return back()->with('success', count($ids) . ' servicio(s) eliminado(s).');
            }
            return back()->with('error', 'No has seleccionado ningún servicio.');
        }

        // Guardar todos los nombres editados
        $ids     = $request->input('ids', []);
        $nombres = $request->input('nombres', []);

        foreach ($ids as $i => $id) {
            $nombre = trim($nombres[$i] ?? '');
            if ($nombre !== '') {
                Especialidad::where('id', $id)->update(['nombre' => $nombre]);
            }
        }

        return back()->with('success', 'Cambios guardados correctamente.');
    }
}

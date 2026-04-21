<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comision;
use App\Models\Usuario;

class ComisionController extends Controller
{
    // 🔹 LISTAR
    public function index()
    {
        if (auth()->user()->rol === 'admin') {
            $comisiones = Comision::with('usuario')->get();
        } else {
            $comisiones = auth()->user()->comisiones;
        }

        return view('comisiones.index', compact('comisiones'));
    }

    // 🔹 FORM CREAR (ADMIN)
    public function create()
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $usuarios = Usuario::all();

        return view('comisiones.create', compact('usuarios'));
    }

    // 🔹 GUARDAR
    public function store(Request $request)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'monto' => 'required|numeric',
            'fecha' => 'required|date'
        ]);

        Comision::create([
            'usuario_id' => $request->usuario_id,
            'monto' => $request->monto,
            'fecha' => $request->fecha
        ]);

        return redirect('/comisiones')->with('success', 'Comisión creada');
    }

    // 🔹 ELIMINAR
    public function destroy($id)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        Comision::findOrFail($id)->delete();

        return redirect('/comisiones')->with('success', 'Comisión eliminada');
    }

        /**
     * Muestra el formulario de edición de una comisión.
     */
    public function edit($id)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $comision = Comision::findOrFail($id);
        $usuarios = \App\Models\Usuario::all();

        return view('comisiones.edit', compact('comision', 'usuarios'));
    }

    /**
     * Actualiza una comisión existente.
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'monto' => 'required|numeric',
            'fecha' => 'required|date'
        ]);

        $comision = Comision::findOrFail($id);

        $comision->update([
            'usuario_id' => $request->usuario_id,
            'monto' => $request->monto,
            'fecha' => $request->fecha
        ]);

        return redirect('/comisiones')->with('success', 'Comisión actualizada correctamente');
    }
}
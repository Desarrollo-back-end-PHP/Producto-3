<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    // 🔴 SOLO ADMIN → LISTA USUARIOS
    public function index()
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $usuarios = Usuario::all();

        return view('usuarios.admin_index', compact('usuarios'));
    }

    // 🟢 PANEL PERSONAL (TODOS)
    public function panel()
    {
        $usuario = auth()->user();
        $usuario->load('comisiones');

        return view('panel', compact('usuario'));
    }

    public function create()
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
            'rol' => 'required'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol
        ]);

        return redirect('/usuarios');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);

        if (auth()->user()->id != $usuario->id && auth()->user()->rol !== 'admin') {
            abort(403);
        }

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
{
    $usuario = Usuario::findOrFail($id);

    // Permitir editar solo su propio perfil o admin
    if (auth()->user()->id != $usuario->id && auth()->user()->rol !== 'admin') {
        abort(403);
    }

    $data = [
        'nombre' => $request->nombre,
        'email' => $request->email,
    ];

    // Contraseña opcional
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    // Solo admin puede cambiar rol
    if (auth()->user()->rol === 'admin') {
        $data['rol'] = $request->rol;
    }

    $usuario->update($data);

    // Redirección inteligente
    if (auth()->user()->rol === 'admin' && auth()->user()->id != $usuario->id) {
        return redirect('/usuarios')->with('success', 'Usuario actualizado');
    }

    return redirect('/panel')->with('success', 'Perfil actualizado');
}

    public function destroy($id)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        Usuario::findOrFail($id)->delete();

        return redirect('/usuarios');
    }
}
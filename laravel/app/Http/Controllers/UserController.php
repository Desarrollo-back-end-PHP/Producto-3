<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // REGISTRO (PÚBLICO)
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',
        ]);

        return redirect('/login')->with('success', 'Usuario creado correctamente');
    }

    //Usuario
    public function perfil()
{
    return view('auth.perfil');
}

public function actualizarPerfil(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6|confirmed'
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
    ];

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return back()->with('success', 'Perfil actualizado correctamente');
}

    // ADMIN: CREAR USUARIO
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'rol'      => 'required|in:admin,tecnico,gestora,cliente',
            'password' => 'required|min:6',
        ]);

        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => $request->rol,
            'activo'   => 1,
        ];

        if ($request->rol === 'tecnico') {
            $data['telefono']        = $request->telefono;
            $data['especialidad_id'] = $request->especialidad_id ?: null;
        }

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'Usuario creado correctamente.');
    }

    // ADMIN → LISTAR USUARIOS
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // ADMIN → ACTUALIZAR USUARIO COMPLETO
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'rol' => 'required|in:admin,tecnico,gestora,cliente',
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ];

        // Solo actualiza password si se rellena
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Usuario actualizado correctamente');
    }

    // ADMIN: ELIMINAR USUARIO
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
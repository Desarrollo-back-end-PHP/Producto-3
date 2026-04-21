<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    // LOGIN VIEW
    public function showLogin()
    {
        return view('auth.login');
    }

    // LOGIN LOGIC
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->rol == 'admin') {
                return redirect('/usuarios');
            } else {
                return redirect('/panel');
            }
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

    // REGISTER VIEW
    public function showRegister()
    {
        return view('auth.registro');
    }

    // REGISTER LOGIC
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // IMPORTANTE: SIEMPRE PARTICULAR
            'rol' => 'particular'
        ]);

        return redirect('/login')->with('success', 'Usuario creado correctamente');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
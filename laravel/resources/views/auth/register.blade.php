@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">

        <h3 class="mb-3">Registro</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input type="text" name="name" class="form-control mb-2" placeholder="Nombre" required>

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

            <input type="password" name="password_confirmation" class="form-control mb-2" placeholder="Repetir contraseña" required>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>

        <div class="mt-2 text-center">
            <a href="{{ route('login') }}">¿Ya tienes cuenta? Inicia sesión</a>
        </div>

    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">

        <h3 class="mb-3">Login</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="mt-2 text-center">
            <a href="{{ route('register') }}">Crear cuenta</a>
        </div>

    </div>
</div>
@endsection
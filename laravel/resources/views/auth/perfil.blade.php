@extends('layouts.app')

@section('content')

<h1 class="mb-4">Mi Perfil</h1>

<div class="card">
    <div class="card-header fw-bold">Datos de Usuario</div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('perfil.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control"
                       value="{{ auth()->user()->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ auth()->user()->email }}" required>
            </div>

            <hr>

            <h5>Cambiar contraseña</h5>

            <div class="mb-3">
                <input type="password" name="password" class="form-control"
                       placeholder="Nueva contraseña">
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="Confirmar contraseña">
            </div>

            <button class="btn btn-primary">
                Guardar cambios
            </button>

        </form>

    </div>
</div>

@endsection
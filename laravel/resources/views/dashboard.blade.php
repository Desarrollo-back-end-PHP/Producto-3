@extends('layouts.app')

@section('content')

<h1 class="mb-4">Panel de Cliente</h1>

<div class="card">
    <div class="card-body">

        <h4 class="mb-3">
            👋 Bienvenido, {{ auth()->user()->name }}
        </h4>

        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Rol:</strong> {{ auth()->user()->rol }}</p>

        <hr>

        <a href="{{ route('perfil') }}" class="btn btn-primary">
            Editar Perfil
        </a>

        <a href="{{ route('incidencias.index') }}" class="btn btn-outline-primary">
            Mis Avisos
        </a>

        <a href="{{ route('incidencias.create') }}" class="btn btn-outline-success">
            Nueva Solicitud
        </a>

    </div>
</div>

@endsection
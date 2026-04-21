<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1>Editar Usuario</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/usuarios/{{ $usuario->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email) }}">
    </div>

    <div class="mb-3">
        <label>Nueva contraseña</label>
        <input type="password" name="password" class="form-control">
        <small>Déjalo vacío si no deseas cambiarla</small>
    </div>

    @if(auth()->user()->rol == 'admin')
    <div class="mb-3">
        <label>Rol</label>
        <select name="rol" class="form-control">
            <option value="admin" {{ $usuario->rol == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="tecnico" {{ $usuario->rol == 'tecnico' ? 'selected' : '' }}>Técnico</option>
            <option value="particular" {{ $usuario->rol == 'particular' ? 'selected' : '' }}>Particular</option>
            <option value="gestora" {{ $usuario->rol == 'gestora' ? 'selected' : '' }}>Gestora</option>
        </select>
    </div>
    @endif

    <button class="btn btn-success">Actualizar</button>

    @if(auth()->user()->rol == 'admin' && auth()->user()->id != $usuario->id)
        <a href="/usuarios" class="btn btn-secondary">Volver</a>
    @else
        <a href="/panel" class="btn btn-secondary">Volver</a>
    @endif

</form>

</body>
</html>
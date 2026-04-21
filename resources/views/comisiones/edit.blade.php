<!DOCTYPE html>
<html>
<head>
    <title>Editar Comisión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1>Editar Comisión</h1>

<form action="/comisiones/{{ $comision->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Usuario</label>
        <select name="usuario_id" class="form-control">
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}"
                    {{ $usuario->id == $comision->usuario_id ? 'selected' : '' }}>
                    {{ $usuario->nombre }} ({{ $usuario->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Monto (€)</label>
        <input type="number" step="0.01" name="monto" class="form-control" value="{{ $comision->monto }}">
    </div>

    <div class="mb-3">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control" value="{{ $comision->fecha }}">
    </div>

    <button class="btn btn-success">Actualizar</button>
    <a href="/comisiones" class="btn btn-secondary">Volver</a>

</form>

</body>
</html>
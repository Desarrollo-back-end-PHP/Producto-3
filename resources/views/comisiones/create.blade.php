<!DOCTYPE html>
<html>
<head>
    <title>Crear Comisión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1>Crear Comisión</h1>

<form action="/comisiones" method="POST">
    @csrf

    <div class="mb-3">
        <label>Usuario</label>
        <select name="usuario_id" class="form-control">
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">
                    {{ $usuario->nombre }} ({{ $usuario->email }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Monto (€)</label>
        <input type="number" step="0.01" name="monto" class="form-control">
    </div>

    <div class="mb-3">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control">
    </div>

    <button class="btn btn-success">Guardar</button>
</form>

</body>
</html>
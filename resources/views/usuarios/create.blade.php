<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1>Crear Usuario</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/usuarios" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Rol</label>
        <select name="rol" class="form-control">

            <option value="admin">Admin</option>
            <option value="tecnico">Técnico</option>
            <option value="particular">Particular</option>
            <option value="gestora">Gestora</option>

        </select>
    </div>

    <button class="btn btn-success">Guardar</button>
    <a href="/usuarios" class="btn btn-secondary">Volver</a>

</form>

</body>
</html>
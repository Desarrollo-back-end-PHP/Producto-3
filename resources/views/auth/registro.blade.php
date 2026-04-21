<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

<h2>Registro</h2>

<!-- MENSAJE DE ERROR -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- ERRORES VALIDACIÓN -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/registro">
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
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <!-- ROL FIJO (NO VISIBLE) -->
    <input type="hidden" name="rol" value="particular">

    <button type="submit" class="btn btn-primary">Registrarse</button>

    <a href="/login" class="btn btn-secondary">Ya tengo una cuenta</a>

</form>

</body>
</html>
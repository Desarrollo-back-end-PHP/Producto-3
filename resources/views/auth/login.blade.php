<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-5">

    <h2>Login</h2>
    
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Entrar</button>
            <a href="/" class="btn btn-secondary">Volver</a>
        </div>

        <p class="mt-3">
            ¿No tienes cuenta?
            <a href="/registro">Regístrate</a>
        </p>

    </form>

</body>
</html>
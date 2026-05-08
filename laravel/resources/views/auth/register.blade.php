<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa — Crear cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a252f 0%, #2c3e50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
        }
        .brand-title { color: #1a252f; font-weight: 800; font-size: 2rem; letter-spacing: 1px; }
        .brand-title span { color: #e74c3c; }
        .form-control:focus { border-color: #e74c3c; box-shadow: 0 0 0 .2rem rgba(231,76,60,.15); }
        .input-group-text { background: #f8f9fa; color: #7f8c8d; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-4">
        <div class="brand-title">Repara<span>Ya</span></div>
        <p class="text-muted small mb-0">Crea tu cuenta de cliente</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label small text-muted fw-semibold">Nombre</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" class="form-control"
                       placeholder="Tu nombre completo" value="{{ old('name') }}" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small text-muted fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control"
                       placeholder="correo@ejemplo.com" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small text-muted fw-semibold">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small text-muted fw-semibold">Repetir contraseña</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold py-2">
            Crear cuenta
        </button>
    </form>

    <hr class="my-3">
    <p class="text-center text-muted small mb-0">
        ¿Ya tienes cuenta?
        <a href="{{ route('login') }}" class="text-danger fw-semibold">Inicia sesión</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

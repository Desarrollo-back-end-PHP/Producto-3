<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        nav { background: #2c3e50; }
        nav a { color: white !important; }
        .urgente { background: #e74c3c; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .estandar { background: #27ae60; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="/">ReparaYa</a>
    <div class="navbar-nav ms-auto">
        <a class="nav-link" href="{{ route('admin.panel') }}">Panel Admin</a>
        <a class="nav-link" href="{{ route('admin.calendario') }}">Calendario</a>
        <a class="nav-link" href="{{ route('admin.liquidaciones') }}">Liquidaciones</a>
    </div>
</nav>
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
@yield('scripts')
</body>
</html>
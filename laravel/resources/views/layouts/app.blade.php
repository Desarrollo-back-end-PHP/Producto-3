<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        nav { background: #2c3e50; }
        nav a { color: white !important; }

        .urgente { background: #e74c3c; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
        .estandar { background: #27ae60; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand text-white fw-bold" href="{{ route('dashboard') }}">
        ReparaYa
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">

        {{-- NAV LINKS --}}
        @auth
            @if(auth()->user()->rol === 'admin')
                <a class="nav-link text-white" href="{{ route('admin.panel') }}">Panel Admin</a>
            @endif

            @if(auth()->user()->rol === 'gestora')
                <a class="nav-link text-white" href="{{ route('gestora.panel') }}">Panel Gestora</a>
            @endif

            @if(auth()->user()->rol === 'tecnico')
                <a class="nav-link text-white" href="{{ route('tecnico.panel') }}">Panel Técnico</a>
            @endif
        @endauth

        {{-- 🔔 NOTIFICACIONES --}}
        @auth
        <div class="dropdown">
            <a class="nav-link position-relative text-white" data-bs-toggle="dropdown" style="cursor:pointer;">
                🔔

                @if(auth()->user()->notificacionesNoLeidas->count())
                    <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                        {{ auth()->user()->notificacionesNoLeidas->count() }}
                    </span>
                @endif
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                @forelse(auth()->user()->notificaciones->take(5) as $n)
                    <li class="dropdown-item small {{ $n->leida ? '' : 'fw-bold bg-light' }}">
                        {{ $n->mensaje }}
                    </li>
                @empty
                    <li class="dropdown-item">Sin notificaciones</li>
                @endforelse

                <li><hr class="dropdown-divider"></li>

                <li>
                    <form method="POST" action="{{ route('notificaciones.leidas') }}">
                        @csrf
                        <button class="dropdown-item text-center text-primary">
                            Marcar todas como leídas
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @endauth

        {{-- PERFIL --}}
        @auth
        <a href="{{ route('perfil') }}" class="btn btn-sm btn-outline-light">
            Perfil
        </a>
        @endauth

        {{-- LOGOUT --}}
        @auth
        <form method="POST" action="{{ route('logout') }}" class="mb-0">
            @csrf
            <button class="btn btn-sm btn-light">
                Salir
            </button>
        </form>
        @endauth

    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>
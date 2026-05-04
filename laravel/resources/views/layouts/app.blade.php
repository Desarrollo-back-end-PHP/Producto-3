<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReparaYa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }

        /* NAV */
        .navbar-reparaya { background: #1a252f; border-bottom: 3px solid #e74c3c; }
        .navbar-reparaya .navbar-brand { color: #fff !important; font-weight: 700; font-size: 1.3rem; letter-spacing: 1px; }
        .navbar-reparaya .navbar-brand span { color: #e74c3c; }
        .navbar-reparaya .nav-link { color: rgba(255,255,255,.8) !important; font-size: .9rem; padding: .4rem .75rem; border-radius: 4px; transition: background .2s; }
        .navbar-reparaya .nav-link:hover { background: rgba(255,255,255,.1); color: #fff !important; }
        .navbar-reparaya .nav-link.active { background: rgba(255,255,255,.15); color: #fff !important; }
        .navbar-reparaya .dropdown-menu { border: none; box-shadow: 0 4px 15px rgba(0,0,0,.15); border-radius: 8px; }

        /* CARDS */
        .card { border: none; box-shadow: 0 1px 6px rgba(0,0,0,.08); border-radius: 10px; }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; font-weight: 600; color: #2c3e50; padding: .85rem 1.25rem; }

        /* TABLAS */
        .table thead th { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; color: #6c757d; background: #f8f9fa; border-bottom: 2px solid #dee2e6; }
        .table tbody tr:hover { background-color: #f8f9fa; }

        /* HEADINGS */
        h1 { font-size: 1.55rem; color: #1a252f; font-weight: 700; }
        h2 { font-size: 1.3rem; color: #1a252f; font-weight: 600; }

        /* BADGES */
        .urgente  { background: #e74c3c; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }
        .estandar { background: #27ae60; color: white; padding: 3px 8px; border-radius: 4px; font-size: 12px; }

        /* ALERTS */
        .alert { border-radius: 8px; border: none; }

        /* SEPARADOR ROL */
        .nav-role-label { color: rgba(255,255,255,.4) !important; font-size: .75rem; text-transform: uppercase; letter-spacing: .05em; padding: .4rem .5rem; cursor: default; }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg px-4 navbar-reparaya">
    <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
        Repara<span>Ya</span>
    </a>

    <button class="navbar-toggler border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav me-auto gap-1 ms-3">
            @auth
                {{-- ADMIN --}}
                @if(auth()->user()->rol === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.panel') ? 'active' : '' }}"
                           href="{{ route('admin.panel') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
                           href="{{ route('admin.users') }}">
                            <i class="bi bi-people me-1"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.calendario') ? 'active' : '' }}"
                           href="{{ route('admin.calendario') }}">
                            <i class="bi bi-calendar3 me-1"></i> Calendario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.liquidaciones') ? 'active' : '' }}"
                           href="{{ route('admin.liquidaciones') }}">
                            <i class="bi bi-cash-stack me-1"></i> Liquidaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.tecnicos') ? 'active' : '' }}"
                           href="{{ route('admin.tecnicos') }}">
                            <i class="bi bi-tools me-1"></i> Técnicos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.servicios') ? 'active' : '' }}"
                           href="{{ route('admin.servicios') }}">
                            <i class="bi bi-tags me-1"></i> Servicios
                        </a>
                    </li>
                @endif

                {{-- GESTORA --}}
                @if(auth()->user()->rol === 'gestora')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gestora.panel') ? 'active' : '' }}"
                           href="{{ route('gestora.panel') }}">
                            <i class="bi bi-building me-1"></i> Mi Panel
                        </a>
                    </li>
                @endif

                {{-- TÉCNICO --}}
                @if(auth()->user()->rol === 'tecnico')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tecnico.panel') ? 'active' : '' }}"
                           href="{{ route('tecnico.panel') }}">
                            <i class="bi bi-tools me-1"></i> Mis Avisos
                        </a>
                    </li>
                @endif
            @endauth
        </ul>

        <ul class="navbar-nav align-items-center gap-2">

            {{-- NOTIFICACIONES --}}
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link position-relative" data-bs-toggle="dropdown" style="cursor:pointer;">
                    <i class="bi bi-bell fs-5"></i>
                    @if(auth()->user()->notificacionesNoLeidas->count())
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:.65rem;">
                            {{ auth()->user()->notificacionesNoLeidas->count() }}
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width:280px;">
                    <li class="px-3 py-2 text-muted small fw-bold border-bottom">Notificaciones</li>
                    @forelse(auth()->user()->notificaciones->take(5) as $n)
                        <li class="dropdown-item small py-2 {{ $n->leida ? 'text-muted' : 'fw-bold' }}">
                            <i class="bi bi-dot text-primary"></i> {{ $n->mensaje }}
                        </li>
                    @empty
                        <li class="dropdown-item text-muted small py-3 text-center">Sin notificaciones</li>
                    @endforelse
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('notificaciones.leidas') }}">
                            @csrf
                            <button class="dropdown-item text-center text-primary small">
                                Marcar todas como leídas
                            </button>
                        </form>
                    </li>
                </ul>
            </li>

            {{-- USUARIO --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown" style="cursor:pointer;">
                    <span class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white"
                          style="width:30px;height:30px;font-size:.8rem;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="d-none d-md-inline" style="color:rgba(255,255,255,.85);font-size:.9rem;">
                        {{ auth()->user()->name }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="px-3 py-2 border-bottom">
                        <small class="text-muted d-block">{{ auth()->user()->email }}</small>
                        <span class="badge bg-secondary mt-1">{{ ucfirst(auth()->user()->rol) }}</span>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('perfil') }}">
                            <i class="bi bi-person me-2"></i> Mi perfil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            @endauth

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                </li>
            @endguest

        </ul>
    </div>
</nav>

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>

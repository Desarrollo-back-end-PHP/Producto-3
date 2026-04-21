<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">

        <a class="navbar-brand" href="/panel">ReparaYa</a>

        <div class="collapse navbar-collapse">

            <ul class="navbar-nav me-auto">

                <!-- ADMIN -->
                @if(auth()->user()->rol == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="/usuarios">Usuarios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/usuarios/create">Crear Usuario</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/comisiones">Comisiones</a>
                    </li>
                @endif


                <!-- TECNICO -->
                @if(auth()->user()->rol == 'tecnico')
                    <li class="nav-item">
                        <a class="nav-link" href="/panel">Panel Técnico</a>
                    </li>
                @endif


                <!-- PARTICULAR -->
                @if(auth()->user()->rol == 'particular')
                    <li class="nav-item">
                        <a class="nav-link" href="/panel">Mi Panel</a>
                    </li>
                @endif


                <!-- GESTORA -->
                @if(auth()->user()->rol == 'gestora')
                    <li class="nav-item">
                        <a class="nav-link" href="/panel">Panel Gestora</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/comisiones">Mis Comisiones</a>
                    </li>
                @endif

            </ul>

            <!-- DERECHA -->
            <div class="d-flex align-items-center">

    <a href="/usuarios/{{ auth()->user()->id }}/edit" class="btn btn-primary btn-sm me-2">
        Editar perfil
    </a>

    <span class="text-white me-3">
        {{ auth()->user()->nombre }} ({{ auth()->user()->rol }})
    </span>

    <a href="/logout" class="btn btn-danger btn-sm">
        Cerrar sesión
    </a>

</div>
    </div>
</nav>
<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1 class="mb-4">Panel</h1>

<!-- ADMIN -->
@if($usuario->rol == 'admin')

<div class="alert alert-info">
    Panel de administración
</div>

<div class="mb-3">
    <a href="/usuarios" class="btn btn-dark">Gestionar usuarios</a>
    <a href="/comisiones/create" class="btn btn-success">Crear comisión</a>
</div>

@endif


<!-- TECNICO -->
@if($usuario->rol == 'tecnico')

<div class="alert alert-warning">
    Panel técnico
</div>

<p>Aquí irá la gestión de incidencias.</p>

@endif


<!-- PARTICULAR -->
@if($usuario->rol == 'particular')

<div class="alert alert-secondary">
    Panel de usuario
</div>

<p>Consulta tu información y comisiones.</p>

@endif


<!-- GESTORA -->
@if($usuario->rol == 'gestora')

<div class="alert alert-primary">
    Panel de gestora
</div>

<p>Consulta comisiones y gestiona avisos.</p>

@endif


<!-- COMISIONES -->
<h3 class="mt-4">Comisiones</h3>

<div class="card p-3">

    @php
        $total = $usuario->comisiones->sum('monto');
    @endphp

    <p><strong>Total acumulado:</strong> {{ $total }} €</p>

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Monto</th>
                <th>Fecha</th>

                @if($usuario->rol == 'admin')
                    <th>Acciones</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @forelse ($usuario->comisiones as $comision)
            <tr>
                <td>{{ $comision->monto }} €</td>
                <td>{{ $comision->fecha }}</td>

                @if($usuario->rol == 'admin')
                <td>
                    <a href="/comisiones/{{ $comision->id }}/edit" class="btn btn-warning btn-sm">Editar</a>

                    <form action="/comisiones/{{ $comision->id }}/delete" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
                @endif

            </tr>
            @empty
            <tr>
                <td colspan="3">No hay comisiones</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
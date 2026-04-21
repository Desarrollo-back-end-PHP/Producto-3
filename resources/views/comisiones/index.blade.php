<!DOCTYPE html>
<html>
<head>
    <title>Comisiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1>Comisiones</h1>

@if(auth()->user()->rol == 'admin')
    <a href="/comisiones/create" class="btn btn-primary mb-3">Nueva Comisión</a>
@endif

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            @if(auth()->user()->rol == 'admin')
                <th>Usuario</th>
            @endif
            <th>Monto</th>
            <th>Fecha</th>
            @if(auth()->user()->rol == 'admin')
                <th>Acciones</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse ($comisiones as $comision)
        <tr>
            @if(auth()->user()->rol == 'admin')
                <td>{{ $comision->usuario->nombre }}</td>
            @endif

            <td>{{ $comision->monto }} €</td>
            <td>{{ $comision->fecha }}</td>

            @if(auth()->user()->rol == 'admin')
            <td>
                <a href="/comisiones/{{ $comision->id }}/edit" class="btn btn-warning btn-sm">
    Editar
</a>

<form action="/comisiones/{{ $comision->id }}/delete" method="POST" style="display:inline;">
    @csrf
    <button class="btn btn-danger btn-sm">Eliminar</button>
</form>
            </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="4">No hay comisiones</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
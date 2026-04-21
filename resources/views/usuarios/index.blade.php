<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1 class="mb-4">Mi Panel</h1>

<div class="card mb-4">
    <div class="card-body">
        <h5>{{ $usuario->nombre }}</h5>
        <p>{{ $usuario->email }}</p>
        <p>Rol: {{ $usuario->rol }}</p>

        <a href="/usuarios/{{ $usuario->id }}/edit" class="btn btn-primary">
            Editar perfil
        </a>
    </div>
</div>

<h3>Mis Comisiones</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($usuario->comisiones as $comision)
            <tr>
                <td>{{ $comision->monto }} €</td>
                <td>{{ $comision->fecha }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No tienes comisiones</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
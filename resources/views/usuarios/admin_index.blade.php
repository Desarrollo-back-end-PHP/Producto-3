<!DOCTYPE html>
<html>
<head>
    <title>Usuarios (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

@include('layouts.navbar')

<h1 class="mb-4">Gestión de Usuarios</h1>

<a href="/usuarios/create" class="btn btn-primary mb-3">Crear usuario</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->rol }}</td>
            <td>
                <a href="/usuarios/{{ $usuario->id }}/edit" class="btn btn-warning btn-sm">Editar</a>

                <form action="/usuarios/{{ $usuario->id }}/delete" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que quieres eliminar este usuario?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
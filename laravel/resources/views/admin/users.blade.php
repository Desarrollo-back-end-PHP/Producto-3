@extends('layouts.app')

@section('content')

<h2>Gestión de Usuarios</h2>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Password</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf

                <td>{{ $user->id }}</td>

                <td>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                </td>

                <td>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                </td>

                <td>
                    <select name="rol" class="form-select">
                        <option value="cliente" {{ $user->rol=='cliente' ? 'selected' : '' }}>Cliente</option>
                        <option value="tecnico" {{ $user->rol=='tecnico' ? 'selected' : '' }}>Técnico</option>
                        <option value="gestora" {{ $user->rol=='gestora' ? 'selected' : '' }}>Gestora</option>
                        <option value="admin" {{ $user->rol=='admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </td>

                <td>
                    <input type="password" name="password" class="form-control" placeholder="Nueva contraseña">
                </td>

                <td>
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                </td>

            </form>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
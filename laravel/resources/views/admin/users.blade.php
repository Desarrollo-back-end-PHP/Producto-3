@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Gestión de Usuarios</h1>
</div>

{{-- NUEVO USUARIO --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Nuevo Usuario
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Nombre *" required>
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email *" required>
                </div>
                <div class="col-md-2">
                    <select name="rol" class="form-select" required>
                        <option value="">Rol *</option>
                        <option value="cliente">Cliente</option>
                        <option value="tecnico">Técnico</option>
                        <option value="gestora">Gestora</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña *" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i> Crear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- LISTADO USUARIOS --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-people me-2"></i>Usuarios registrados
        <span class="badge bg-secondary ms-2">{{ count($users) }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width:45px">#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th style="width:120px">Rol</th>
                    <th style="width:155px">Nueva contraseña</th>
                    <th style="width:180px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-muted small">{{ $user->id }}</td>

                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf

                        <td>
                            <input type="text" name="name" value="{{ $user->name }}"
                                   class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="email" name="email" value="{{ $user->email }}"
                                   class="form-control form-control-sm">
                        </td>
                        <td>
                            <select name="rol" class="form-select form-select-sm">
                                <option value="cliente" {{ $user->rol=='cliente' ? 'selected' : '' }}>Cliente</option>
                                <option value="tecnico" {{ $user->rol=='tecnico' ? 'selected' : '' }}>Técnico</option>
                                <option value="gestora" {{ $user->rol=='gestora' ? 'selected' : '' }}>Gestora</option>
                                <option value="admin"   {{ $user->rol=='admin'   ? 'selected' : '' }}>Admin</option>
                            </select>
                        </td>
                        <td>
                            <input type="password" name="password"
                                   class="form-control form-control-sm" placeholder="Sin cambios">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-check-lg"></i> Guardar
                            </button>
                        </td>

                    </form>

                    {{-- Botón borrar fuera del form de edición --}}
                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user->id) }}"
                                  onsubmit="return confirm('Borrar usuario {{ addslashes($user->name) }}?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @else
                            <span class="text-muted small">Tú</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

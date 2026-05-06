@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Gestión de Técnicos</h1>
</div>

{{-- AÑADIR TÉCNICO --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-person-plus me-2"></i>Añadir Técnico
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.tecnicos.store') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="name" class="form-control"
                       placeholder="Nombre completo *" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control"
                       placeholder="Email" value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <select name="especialidad_id" class="form-select">
                    <option value="">-- Seleccionar especialidad --</option>
                    @foreach($especialidades as $esp)
                        <option value="{{ $esp->id }}" {{ old('especialidad_id') == $esp->id ? 'selected' : '' }}>
                            {{ $esp->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="telefono" class="form-control"
                       placeholder="Teléfono" value="{{ old('telefono') }}">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control"
                       placeholder="Contraseña de acceso (para que pueda loguearse)">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Añadir Técnico
            </button>
        </form>
    </div>
</div>

{{-- LISTADO --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-tools me-2"></i>Técnicos registrados
        <span class="badge bg-secondary ms-2">{{ count($tecnicos) }}</span>
    </div>
    <div class="card-body p-0">
        @if($tecnicos->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x" style="font-size:2rem;"></i>
                <p class="mt-2">No hay técnicos registrados.</p>
            </div>
        @else
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th style="width:160px">Especialidad</th>
                    <th style="width:130px">Teléfono</th>
                    <th style="width:80px">Estado</th>
                    <th style="width:130px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tecnicos as $tecnico)
                <tr>
                    <form method="POST" action="{{ route('admin.tecnicos.update', $tecnico->id) }}">
                        @csrf
                        <td>
                            <input type="text" name="name" value="{{ $tecnico->name }}"
                                   class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="email" name="email" value="{{ $tecnico->email }}"
                                   class="form-control form-control-sm">
                        </td>
                        <td>
                            <select name="especialidad_id" class="form-select form-select-sm">
                                <option value="">Sin especialidad</option>
                                @foreach($especialidades as $esp)
                                    <option value="{{ $esp->id }}"
                                        {{ $tecnico->especialidad_id == $esp->id ? 'selected' : '' }}>
                                        {{ $esp->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="telefono" value="{{ $tecnico->telefono }}"
                                   class="form-control form-control-sm" placeholder="Teléfono">
                        </td>
                        <td>
                            @if($tecnico->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Baja</span>
                            @endif
                        </td>
                        <td class="d-flex gap-2">
    <button type="submit" class="btn btn-success btn-sm">
        Guardar
    </button>

    <form method="POST" action="{{ route('admin.tecnicos.baja', $tecnico->id) }}"
        onsubmit="return confirm('{{ $tecnico->activo ? 'Dar de baja a ' : 'Reactivar a ' }}{{ addslashes($tecnico->name) }}?')">
        @csrf
        <button type="submit"
            class="btn btn-sm {{ $tecnico->activo ? 'btn-outline-danger' : 'btn-outline-success' }}">
            {{ $tecnico->activo ? 'Baja' : 'Activar' }}
        </button>
    </form>
</td>
                    </form>

                    
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.servicios') }}" class="btn btn-success btn-sm">
        <i class="bi bi-tags me-1"></i> Gestionar Tipos de Servicio
    </a>
    <a href="{{ route('admin.panel') }}" class="btn btn-primary btn-sm ms-2">
        <i class="bi bi-arrow-left me-1"></i> Volver al Panel
    </a>
</div>

@endsection

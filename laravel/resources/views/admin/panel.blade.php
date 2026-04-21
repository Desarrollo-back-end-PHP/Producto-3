@extends('layouts.app')

@section('content')
<h1 class="mb-4">Panel de Administración</h1>

<div class="card mb-4">
    <div class="card-header fw-bold">Nuevo Aviso</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.crear') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="tipo_servicio" class="form-control" placeholder="Tipo de servicio" required>
                </div>
                <div class="col-md-2">
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente (24h)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="franja" class="form-control" placeholder="Franja horaria">
                </div>
                <div class="col-md-6">
                    <textarea name="descripcion" class="form-control" placeholder="Descripción de la avería" required></textarea>
                </div>
                <div class="col-md-4">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                </div>
                <div class="col-md-2">
                    <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Crear Aviso</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">Avisos</span>
        <a href="{{ route('admin.calendario') }}" class="btn btn-sm btn-outline-primary">Ver Calendario</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Código</th><th>Tipo</th><th>Urgencia</th>
                    <th>Fecha</th><th>Estado</th><th>Técnico</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td>{{ $aviso->codigo }}</td>
                    <td>{{ $aviso->tipo_servicio }}</td>
                    <td><span class="{{ $aviso->urgencia }}">{{ $aviso->urgencia }}</span></td>
                    <td>{{ $aviso->fecha ? $aviso->fecha->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $aviso->estado }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.asignarTecnico') }}" class="d-flex gap-1">
                            @csrf
                            <input type="hidden" name="aviso_id" value="{{ $aviso->id }}">
                            <select name="tecnico_id" class="form-select form-select-sm">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos as $t)
                                    <option value="{{ $t->id }}" {{ $aviso->tecnico_id == $t->id ? 'selected' : '' }}>
                                        {{ $t->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-sm btn-secondary">Asignar</button>
                        </form>
                    </td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('admin.editar', $aviso->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('admin.cancelar', $aviso->id) }}" class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Cancelar este aviso?')">Cancelar</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No hay avisos registrados</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
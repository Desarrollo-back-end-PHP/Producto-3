@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Mis Avisos</h1>
    <a href="{{ route('incidencias.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nueva Solicitud
    </a>
</div>

@if ($incidencias->isEmpty())
    <div class="alert alert-info">No tienes ninguna solicitud registrada.</div>
@else
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Fecha Servicio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incidencias as $incidencia)
                    <tr>
                        <td><small class="text-muted">{{ $incidencia->codigo }}</small></td>
                        <td>{{ Str::limit($incidencia->descripcion, 50) }}</td>
                        <td>
                            <span class="{{ $incidencia->tipo_servicio }}">
                                {{ ucfirst($incidencia->tipo_servicio) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $incidencia->estado == 'cancelada' ? 'danger' : ($incidencia->estado == 'completada' ? 'success' : 'warning') }}">
                                {{ ucfirst($incidencia->estado) }}
                            </span>
                        </td>
                        <td>{{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}</td>
                        <td>
                            @if (!in_array($incidencia->estado, ['cancelada', 'completada']))
                                <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres cancelar esta solicitud?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
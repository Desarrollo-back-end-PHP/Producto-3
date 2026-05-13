@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Avisos</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('incidencias.create') }}" class="btn btn-primary mb-3">Nueva Solicitud</a>
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($incidencias as $inc)
                    <tr>
                        <td>{{ $inc->codigo }}</td>
                        <td>{{ $inc->descripcion }}</td>
                        <td>{{ $inc->tipo_servicio }}</td>
                        <td>{{ $inc->fecha_servicio ? $inc->fecha_servicio->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $inc->estado }}</td>
                        <td>
                            <form method="POST" action="{{ route('incidencias.destroy', $inc->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Cancelar esta solicitud?')">Cancelar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">No tienes solicitudes.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
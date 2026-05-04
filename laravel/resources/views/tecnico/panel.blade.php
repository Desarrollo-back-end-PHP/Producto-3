@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-tools me-2"></i>Panel Técnico</h1>
    <span class="badge bg-secondary fs-6">{{ $avisos->count() }} avisos asignados</span>
</div>

{{-- NOTIFICACIONES --}}
@if($notificaciones->where('leida', 0)->count())
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-bell me-2"></i>Notificaciones pendientes
        <span class="badge bg-danger ms-1">{{ $notificaciones->where('leida', 0)->count() }}</span>
    </div>
    <div class="card-body pt-2 pb-1">
        @foreach($notificaciones->where('leida', 0)->take(5) as $n)
            <div class="alert alert-info py-2 mb-2 small">
                <i class="bi bi-info-circle me-1"></i> {{ $n->mensaje }}
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- AVISOS --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-clipboard-list me-2"></i>Mis Avisos
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Dirección</th>
                    <th>Urgencia</th>
                    <th>Fecha</th>
                    <th>Estado actual</th>
                    <th style="width:180px">Actualizar estado</th>
                </tr>
            </thead>
            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td class="font-monospace small align-middle">{{ $aviso->codigo }}</td>
                    <td class="align-middle">{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>
                    <td class="align-middle">{{ $aviso->direccion }}</td>
                    <td class="align-middle">
                        <span class="badge bg-{{ $aviso->urgencia == 'urgente' ? 'danger' : 'success' }}">
                            {{ ucfirst($aviso->urgencia) }}
                        </span>
                    </td>
                    <td class="align-middle small">
                        {{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}
                    </td>
                    <td class="align-middle">
                        @php
                            $color = match($aviso->estado) {
                                'asignada'   => 'primary',
                                'en_proceso' => 'info text-dark',
                                'finalizado' => 'success',
                                default      => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $aviso->estado)) }}</span>
                    </td>
                    <td class="align-middle">
                        <form method="POST" action="{{ route('tecnico.estado') }}" class="d-flex gap-1">
                            @csrf
                            <input type="hidden" name="aviso_id" value="{{ $aviso->id }}">
                            <select name="estado" class="form-select form-select-sm">
                                <option value="asignada"   {{ $aviso->estado == 'asignada'   ? 'selected' : '' }}>Asignada</option>
                                <option value="en_proceso" {{ $aviso->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                                <option value="finalizado" {{ $aviso->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            <button class="btn btn-sm btn-primary">OK</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                        No tienes avisos asignados
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

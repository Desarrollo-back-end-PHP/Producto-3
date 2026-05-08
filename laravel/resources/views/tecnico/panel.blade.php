@extends('layouts.app')

@section('content')

<h1 class="mb-4">Panel Técnico</h1>

{{-- 🔔 NOTIFICACIONES --}}
<div class="card mb-3">
    <div class="card-header fw-bold">Notificaciones</div>

    <div class="card-body">
        @forelse($notificaciones as $n)
            <div class="alert {{ $n->leida ? 'alert-secondary' : 'alert-info' }} py-2 mb-2">
                {{ $n->mensaje }}
            </div>
        @empty
            <p class="text-muted">No tienes notificaciones</p>
        @endforelse
    </div>
</div>

{{-- 📋 AVISOS --}}
<div class="card">
    <div class="card-header fw-bold">Mis Avisos</div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">

            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Dirección</th>
                    <th>Urgencia</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Cambiar</th>
                </tr>
            </thead>

            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td>{{ $aviso->codigo }}</td>

                    {{-- 🔥 FIX --}}
                    <td>{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>

                    <td>{{ $aviso->direccion }}</td>

                    <td>
                        <span class="badge {{ $aviso->urgencia == 'urgente' ? 'bg-danger' : 'bg-success' }}">
                            {{ $aviso->urgencia }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        <span class="badge bg-info">
                            {{ $aviso->estado }}
                        </span>
                    </td>

                    <td>
                        <form method="POST" action="{{ route('tecnico.estado') }}">
                            @csrf

                            <input type="hidden" name="aviso_id" value="{{ $aviso->id }}">

                            <select name="estado" class="form-select form-select-sm mb-1">
                                <option value="asignado" {{ $aviso->estado == 'asignado' ? 'selected' : '' }}>
                                    Asignado
                                </option>

                                <option value="en_proceso" {{ $aviso->estado == 'en_proceso' ? 'selected' : '' }}>
                                    En proceso
                                </option>

                                <option value="finalizado" {{ $aviso->estado == 'finalizado' ? 'selected' : '' }}>
                                    Finalizado
                                </option>
                            </select>

                            <button class="btn btn-sm btn-primary w-100">
                                Actualizar
                            </button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No tienes avisos asignados
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
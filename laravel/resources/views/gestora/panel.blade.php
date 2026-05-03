@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Panel de Gestora</h1>
    <span class="text-muted small">{{ auth()->user()->name }}</span>
</div>

{{-- ========================= --}}
{{-- NUEVO AVISO              --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header fw-bold">
        ➕ Nuevo Aviso
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('gestora.crear') }}">
            @csrf

            <div class="row g-3">

                {{-- ESPECIALIDAD --}}
                <div class="col-md-4">
                    <label class="form-label small text-muted">Tipo de servicio *</label>
                    <select name="especialidad_id" class="form-select" required>
                        <option value="">Selecciona un servicio</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- URGENCIA --}}
                <div class="col-md-2">
                    <label class="form-label small text-muted">Urgencia *</label>
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                {{-- FECHA --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted">Fecha *</label>
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>

                {{-- FRANJA --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted">Franja horaria</label>
                    <input type="text" name="franja" class="form-control" placeholder="Ej: 09:00 - 14:00">
                </div>

                {{-- ZONA --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted">Zona</label>
                    <input type="text" name="zona" class="form-control" placeholder="Ej: Norte, Centro...">
                </div>

                {{-- PRECIO --}}
                <div class="col-md-2">
                    <label class="form-label small text-muted">Precio base (€)</label>
                    <input type="number" name="precio" class="form-control" placeholder="100" min="0" step="0.01">
                </div>

                {{-- DIRECCIÓN --}}
                <div class="col-md-4">
                    <label class="form-label small text-muted">Dirección *</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Calle y número" required>
                </div>

                {{-- TELÉFONO --}}
                <div class="col-md-3">
                    <label class="form-label small text-muted">Teléfono *</label>
                    <input type="tel" name="telefono" class="form-control" placeholder="6XXXXXXXX" required>
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="col-12">
                    <label class="form-label small text-muted">Descripción *</label>
                    <textarea name="descripcion" class="form-control" rows="2" placeholder="Describe el problema..." required></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Crear Aviso</button>
                </div>

            </div>
        </form>

    </div>
</div>

{{-- ========================= --}}
{{-- MIS AVISOS               --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header fw-bold">
        📋 Mis Avisos
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">

            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Urgencia</th>
                    <th>Zona</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Técnico asignado</th>
                </tr>
            </thead>

            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td><span class="font-monospace small">{{ $aviso->codigo }}</span></td>
                    <td>{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $aviso->urgencia == 'urgente' ? 'danger' : 'success' }}">
                            {{ ucfirst($aviso->urgencia) }}
                        </span>
                    </td>
                    <td>{{ $aviso->zona ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $estadoColor = match($aviso->estado) {
                                'pendiente'  => 'warning text-dark',
                                'asignada'   => 'primary',
                                'finalizado' => 'success',
                                default      => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $estadoColor }}">
                            {{ ucfirst($aviso->estado) }}
                        </span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('gestora.asignarTecnico') }}" class="d-flex gap-1">
                            @csrf
                            <input type="hidden" name="aviso_id" value="{{ $aviso->id }}">
                            <select name="tecnico_id" class="form-select form-select-sm">
                                <option value="">Sin asignar</option>
                                @foreach($tecnicos as $t)
                                    <option value="{{ $t->id }}" {{ $aviso->tecnico_id == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-secondary">OK</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-3">
                        No tienes avisos registrados
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- MIS COMISIONES           --}}
{{-- ========================= --}}
<div class="card">
    <div class="card-header fw-bold">
        💰 Mis Comisiones (acumulado mensual)
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">

            <thead class="table-light">
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Total acumulado (€)</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
            @forelse($comisiones as $c)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($c->mes)->translatedFormat('F') }}</td>
                    <td>{{ $c->anyo }}</td>
                    <td><strong>{{ number_format($c->total, 2) }} €</strong></td>
                    <td>
                        @if($c->estado === 'liquidada')
                            <span class="badge bg-success">Liquidada</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        No hay comisiones registradas todavía
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection

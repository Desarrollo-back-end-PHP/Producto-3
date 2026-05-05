@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-building me-2"></i>Panel de Gestora</h1>
    <span class="text-muted small">{{ auth()->user()->name }}</span>
</div>

{{-- ========================= --}}
{{-- NUEVO AVISO              --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2"></i>Nuevo Aviso
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

                <div class="col-md-4">
                    <label class="form-label small text-muted fw-semibold">Tipo de servicio *</label>
                    <select name="especialidad_id" class="form-select" required>
                        <option value="">Selecciona un servicio</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted fw-semibold">Urgencia *</label>
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Fecha *</label>
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Franja horaria</label>
                    <input type="text" name="franja" class="form-control" placeholder="Ej: 09:00 - 14:00">
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Zona</label>
                    <input type="text" name="zona" class="form-control"
                           list="lista-zonas" placeholder="Zona">
                    <datalist id="lista-zonas">
                        @foreach($zonas as $zona)
                            <option value="{{ $zona }}">
                        @endforeach
                    </datalist>
                </div>

                <div class="col-md-2">
                    <label class="form-label small text-muted fw-semibold">Precio base (€)</label>
                    <input type="number" name="precio" class="form-control" placeholder="100" min="0" step="0.01">
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted fw-semibold">Dirección *</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Calle y número" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Teléfono *</label>
                    <input type="tel" name="telefono" class="form-control" placeholder="6XXXXXXXX" required>
                </div>

                <div class="col-12">
                    <label class="form-label small text-muted fw-semibold">Descripción *</label>
                    <textarea name="descripcion" class="form-control" rows="2"
                              placeholder="Describe el problema..." required></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> Crear Aviso
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- ========================= --}}
{{-- MIS AVISOS               --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-clipboard-list me-2"></i>Mis Avisos
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Urgencia</th>
                    <th>Zona</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Técnico asignado</th>
                    <th style="width:100px">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td class="font-monospace small align-middle">{{ $aviso->codigo }}</td>
                    <td class="align-middle">{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>
                    <td class="align-middle">
                        <span class="badge bg-{{ $aviso->urgencia == 'urgente' ? 'danger' : 'success' }}">
                            {{ ucfirst($aviso->urgencia) }}
                        </span>
                    </td>
                    <td class="align-middle">{{ $aviso->zona ?? '-' }}</td>
                    <td class="align-middle small">{{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}</td>
                    <td class="align-middle">
                        @php
                            $color = match($aviso->estado) {
                                'pendiente'  => 'warning text-dark',
                                'asignada'   => 'primary',
                                'en_proceso' => 'info text-dark',
                                'finalizado' => 'success',
                                'cancelada'  => 'secondary',
                                default      => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ ucfirst(str_replace('_', ' ', $aviso->estado)) }}</span>
                    </td>
                    <td class="align-middle">
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

                    {{-- Cancelar aviso (solo si no está finalizado) --}}
                    <td class="align-middle">
                        @if($aviso->estado !== 'finalizado')
                            <form method="POST"
                                  action="{{ route('gestora.avisos.cancelar', $aviso->id) }}"
                                  onsubmit="return confirm('¿Cancelar el aviso {{ $aviso->codigo }}?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
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
    <div class="card-header">
        <i class="bi bi-cash-stack me-2"></i>Mis Comisiones (acumulado mensual)
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
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
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-currency-euro fs-4 d-block mb-2"></i>
                        No hay comisiones registradas todavía
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

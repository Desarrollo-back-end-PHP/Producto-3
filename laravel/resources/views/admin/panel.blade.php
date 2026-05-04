@extends('layouts.app')

@section('content')

<h1 class="mb-4">Panel de Administración</h1>

{{-- ========================= --}}
{{-- ACCIONES RÁPIDAS --}}
{{-- ========================= --}}
<div class="mb-4 d-flex flex-wrap gap-2">

    <a href="{{ route('admin.users') }}" class="btn btn-dark">
        <i class="bi bi-people me-1"></i> Usuarios
    </a>

    <a href="{{ route('admin.calendario') }}" class="btn btn-outline-primary">
        <i class="bi bi-calendar3 me-1"></i> Calendario
    </a>

    <a href="{{ route('admin.liquidaciones') }}" class="btn btn-outline-success">
        <i class="bi bi-cash-stack me-1"></i> Liquidaciones
    </a>

    <a href="{{ route('admin.tecnicos') }}" class="btn btn-outline-secondary">
        <i class="bi bi-tools me-1"></i> Técnicos
    </a>

    <a href="{{ route('admin.servicios') }}" class="btn btn-outline-secondary">
        <i class="bi bi-tags me-1"></i> Servicios
    </a>

</div>


{{-- ========================= --}}
{{-- NUEVO AVISO --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Nuevo Aviso</div>

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

        <form method="POST" action="{{ route('admin.crear') }}">
            @csrf

            <div class="row g-3">

                <div class="col-md-4">
                    <select name="especialidad_id" class="form-select" required>
                        <option value="">Tipo de servicio</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="franja" class="form-control" placeholder="Franja horaria">
                </div>

                <div class="col-md-4">
                    <input type="text" name="zona" class="form-control" placeholder="Zona">
                </div>

                <div class="col-md-6">
                    <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
                </div>

                <div class="col-md-4">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                </div>

                <div class="col-md-2">
                    <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Asignar Técnico</label>
                    <select name="tecnico_id" class="form-select">
                        <option value="">Sin técnico</option>
                        @foreach($tecnicos as $t)
                            <option value="{{ $t->id }}">
                                {{ $t->name }} ({{ $t->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Asignar Gestora</label>
                    <select name="gestora_id" class="form-select">
                        <option value="">Sin gestora</option>
                        @foreach($gestoras as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->name }} ({{ $g->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Crear Aviso</button>
                </div>

            </div>
        </form>

    </div>
</div>


{{-- ========================= --}}
{{-- TABLA AVISOS --}}
{{-- ========================= --}}
<div class="card">
    <div class="card-header fw-bold">Avisos</div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">

            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Servicio</th>
                    <th>Urgencia</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Técnico</th>
                    <th>Cambiar Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @forelse($avisos as $aviso)
                <tr>
                    <td>{{ $aviso->codigo }}</td>

                    <td>{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>

                    <td>
                        <span class="badge bg-{{ $aviso->urgencia == 'urgente' ? 'danger' : 'success' }}">
                            {{ $aviso->urgencia }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}
                    </td>

                    <td>
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

                    <td>
                        <form method="POST" action="{{ route('admin.asignarTecnico') }}" class="d-flex gap-1">
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

                            <button class="btn btn-sm btn-secondary">OK</button>
                        </form>
                    </td>

                    <td>
                        <form id="form-estado-{{ $aviso->id }}"
                              method="POST"
                              action="{{ route('admin.actualizar', $aviso->id) }}">
                            @csrf
                            <select name="estado" class="form-select form-select-sm">
                                <option value="pendiente"  {{ $aviso->estado == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                <option value="asignada"   {{ $aviso->estado == 'asignada'   ? 'selected' : '' }}>Asignada</option>
                                <option value="en_proceso" {{ $aviso->estado == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                                <option value="finalizado" {{ $aviso->estado == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                                <option value="cancelada"  {{ $aviso->estado == 'cancelada'  ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </form>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            <button type="submit"
                                    form="form-estado-{{ $aviso->id }}"
                                    class="btn btn-sm btn-primary">
                                Guardar
                            </button>
                            <form method="POST"
                                  action="{{ route('admin.cancelar', $aviso->id) }}"
                                  onsubmit="return confirm('¿Cancelar el aviso {{ $aviso->codigo }}?')">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Cancelar</button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay avisos</td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
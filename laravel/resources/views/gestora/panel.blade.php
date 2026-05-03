@extends('layouts.app')

@section('content')

<h1 class="mb-4">Panel de Gestora</h1>
{{-- ========================= --}}
{{-- NUEVO AVISO --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Nuevo Aviso</div>

    <div class="card-body">

        <form method="POST" action="{{ route('gestora.crear') }}">
            @csrf

            <div class="row g-3">

                {{-- ESPECIALIDAD --}}
                <div class="col-md-4">
                    <select name="especialidad_id" class="form-select" required>
                        <option value="">Tipo de servicio</option>
                        @foreach($especialidades as $e)
                            <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- URGENCIA --}}
                <div class="col-md-2">
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                {{-- FECHA --}}
                <div class="col-md-3">
                    <input type="datetime-local" name="fecha" class="form-control" required>
                </div>

                {{-- FRANJA --}}
                <div class="col-md-3">
                    <input type="text" name="franja" class="form-control" placeholder="Franja horaria">
                </div>

                {{-- ZONA --}}
                <div class="col-md-4">
                    <input type="text" name="zona" class="form-control" placeholder="Zona">
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="col-md-6">
                    <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
                </div>

                {{-- DIRECCIÓN --}}
                <div class="col-md-4">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                </div>

                {{-- TELÉFONO --}}
                <div class="col-md-2">
                    <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Crear Aviso</button>
                </div>

            </div>
        </form>

    </div>
</div>
{{-- ========================= --}}
{{-- MIS AVISOS --}}
{{-- ========================= --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Mis Avisos</div>

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
                </tr>
            </thead>

            <tbody>
            @forelse($avisos as $aviso)
                <tr>

                    <td>{{ $aviso->codigo }}</td>

                    {{-- 🔥 SERVICIO CORRECTO --}}
                    <td>{{ $aviso->especialidad->nombre ?? 'N/A' }}</td>

                    <td>
                        <span class="badge bg-{{ $aviso->urgencia == 'urgente' ? 'danger' : 'success' }}">
                            {{ $aviso->urgencia }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($aviso->fecha)->format('d/m/Y H:i') }}
                    </td>

                    <td>{{ $aviso->estado }}</td>

                    {{-- 🔥 ASIGNAR TÉCNICO --}}
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

                            <button class="btn btn-sm btn-secondary">OK</button>
                        </form>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No tienes avisos
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ========================= --}}
{{-- COMISIONES --}}
{{-- ========================= --}}
<div class="card">
    <div class="card-header fw-bold">Mis Comisiones</div>

    <div class="card-body p-0">
        <table class="table table-bordered mb-0">

            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Total (€)</th>
                </tr>
            </thead>

            <tbody>
            @forelse($comisiones as $c)
                <tr>
                    <td>{{ $c->mes }}</td>
                    <td>{{ $c->anyo }}</td>
                    <td>{{ $c->total }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">
                        No hay comisiones
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
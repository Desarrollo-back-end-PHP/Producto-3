@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Nueva Solicitud</h1>
    <a href="{{ route('incidencias.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Volver a Mis Avisos
    </a>
</div>

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

        <form method="POST" action="{{ route('incidencias.store') }}">
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
                    <select name="tipo_servicio" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Fecha *</label>
                    <input type="datetime-local" name="fecha_servicio" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Franja horaria</label>
                    <input type="text" name="franja" class="form-control" placeholder="Ej: 09:00 - 14:00">
                </div>

                <div class="col-md-3">
                    <label class="form-label small text-muted fw-semibold">Zona</label>
                    <input type="text" name="zona" class="form-control" placeholder="Ej: Centro, Eixample...">
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

@endsection
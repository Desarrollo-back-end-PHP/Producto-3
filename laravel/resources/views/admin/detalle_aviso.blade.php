@extends('layouts.app')

@section('content')
<h1 class="mb-4">Editar Aviso</h1>

<div class="card mb-4">
    <div class="card-header fw-bold">Detalle</div>
    <div class="card-body">
        <p><strong>Código:</strong> {{ $aviso->codigo }}</p>
        <p><strong>Estado:</strong> {{ $aviso->estado }}</p>
        <p><strong>Creado:</strong> {{ $aviso->created_at->format('d/m/Y H:i') }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header fw-bold">Editar datos</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.actualizar', $aviso->id) }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tipo de servicio</label>
                    <input type="text" name="tipo_servicio" class="form-control" value="{{ $aviso->tipo_servicio }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Urgencia</label>
                    <select name="urgencia" class="form-select">
                        <option value="estandar" {{ $aviso->urgencia == 'estandar' ? 'selected' : '' }}>Estándar</option>
                        <option value="urgente" {{ $aviso->urgencia == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="datetime-local" name="fecha" class="form-control"
                        value="{{ $aviso->fecha ? $aviso->fecha->format('Y-m-d\TH:i') : '' }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Franja horaria</label>
                    <input type="text" name="franja" class="form-control" value="{{ $aviso->franja }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" required>{{ $aviso->descripcion }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ $aviso->direccion }}" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Teléfono</label>
                    <input type="tel" name="telefono" class="form-control" value="{{ $aviso->telefono }}" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="{{ route('admin.panel') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
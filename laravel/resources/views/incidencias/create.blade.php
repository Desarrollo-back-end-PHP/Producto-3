@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Nueva Solicitud</h1>
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('incidencias.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tipo de servicio</label>
                    <select name="tipo_servicio" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Fecha del servicio</label>
                    <input type="datetime-local" name="fecha_servicio" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                <a href="{{ route('incidencias.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
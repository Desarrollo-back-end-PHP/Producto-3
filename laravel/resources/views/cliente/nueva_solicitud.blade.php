<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Nueva Solicitud de Servicio</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('incidencias.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del problema</label>
            <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="4">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tipo_servicio" class="form-label">Tipo de servicio</label>
            <select name="tipo_servicio" id="tipo_servicio" class="form-select @error('tipo_servicio') is-invalid @enderror">
                <option value="">-- Selecciona --</option>
                <option value="estandar" {{ old('tipo_servicio') == 'estandar' ? 'selected' : '' }}>Estándar (mín. 48h)</option>
                <option value="urgente" {{ old('tipo_servicio') == 'urgente' ? 'selected' : '' }}>Urgente</option>
            </select>
            @error('tipo_servicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="fecha_servicio" class="form-label">Fecha y hora del servicio</label>
            <input type="datetime-local" name="fecha_servicio" id="fecha_servicio"
                class="form-control @error('fecha_servicio') is-invalid @enderror"
                value="{{ old('fecha_servicio') }}">
            @error('fecha_servicio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Crear Solicitud</button>
        <a href="{{ route('incidencias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
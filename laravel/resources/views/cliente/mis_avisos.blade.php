<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Avisos - ReparaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mis Avisos</h2>
        <a href="{{ route('incidencias.create') }}" class="btn btn-primary">+ Nueva Solicitud</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($incidencias->isEmpty())
        <div class="alert alert-info">No tienes ninguna solicitud registrada.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidencias as $incidencia)
                <tr>
                    <td>{{ $incidencia->codigo }}</td>
                    <td>{{ Str::limit($incidencia->descripcion, 50) }}</td>
                    <td>{{ ucfirst($incidencia->tipo_servicio) }}</td>
                    <td>
                        <span class="badge bg-{{ $incidencia->estado == 'cancelada' ? 'danger' : ($incidencia->estado == 'completada' ? 'success' : 'warning') }}">
                            {{ ucfirst($incidencia->estado) }}
                        </span>
                    </td>
                    <td>{{ $incidencia->fecha_servicio->format('d/m/Y H:i') }}</td>
                    <td>
                        @if (!in_array($incidencia->estado, ['cancelada', 'completada']))
                            <form action="{{ route('incidencias.destroy', $incidencia->id) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que quieres cancelar esta solicitud?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
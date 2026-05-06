@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Tipos de Servicio</h1>
</div>

{{-- AÑADIR NUEVO --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="bi bi-plus-circle me-2"></i>Añadir Tipo de Servicio
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.servicios.store') }}">
            @csrf
            <div class="row g-2 align-items-center">
                <div class="col-md-8">
                    <input type="text" name="nombre" class="form-control"
                           placeholder="Nombre del servicio (ej. Fontanería) *"
                           value="{{ old('nombre') }}" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg me-1"></i> Añadir
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- LISTADO CON EDICIÓN Y BORRADO MÚLTIPLE --}}
<div class="card">
    <div class="card-header">
        <i class="bi bi-tags me-2"></i>Servicios disponibles
        <span class="badge bg-secondary ms-2">{{ count($especialidades) }}</span>
    </div>
    <div class="card-body p-0">

        @if($especialidades->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-tag" style="font-size:2rem;"></i>
                <p class="mt-2">No hay tipos de servicio registrados.</p>
            </div>
        @else

        {{-- Un solo formulario para editar y eliminar varios a la vez --}}
        <form method="POST" action="{{ route('admin.servicios.bulk') }}">
            @csrf

            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        {{-- Checkbox seleccionar todos --}}
                        <th style="width:40px" class="text-center">
                            <input type="checkbox" id="checkAll" title="Seleccionar todos">
                        </th>
                        <th>Nombre</th>
                        <th style="width:80px"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($especialidades as $esp)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="delete[]" value="{{ $esp->id }}" class="check-item">
                        </td>
                        <td>
                            {{-- ID oculto para saber qué fila guardar --}}
                            <input type="hidden" name="ids[]" value="{{ $esp->id }}">
                            <input type="text" name="nombres[]" value="{{ $esp->nombre }}"
                                   class="form-control form-control-sm" required>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Botones de acción masiva --}}
            <div class="d-flex gap-2 p-3 border-top">
                <button type="submit" name="action" value="save" class="btn btn-success btn-sm">
                    <i class="bi bi-check-lg me-1"></i> Guardar todos
                </button>
                <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm"
                        onclick="return confirm('Eliminar los servicios seleccionados?')">
                    <i class="bi bi-trash me-1"></i> Eliminar seleccionados
                </button>
            </div>

        </form>

        @endif
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.tecnicos') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-tools me-1"></i> Gestionar Técnicos
    </a>
    <a href="{{ route('admin.panel') }}" class="btn btn-outline-secondary btn-sm ms-2">
        <i class="bi bi-arrow-left me-1"></i> Volver al Panel
    </a>
</div>

{{-- Seleccionar todos con JS simple --}}
<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        document.querySelectorAll('.check-item').forEach(function (cb) {
            cb.checked = document.getElementById('checkAll').checked;
        });
    });
</script>

@endsection

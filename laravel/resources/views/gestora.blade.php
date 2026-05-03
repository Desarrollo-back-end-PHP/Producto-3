@extends('layouts.app')

@section('content')

<h1 class="mb-4">Panel de Gestora</h1>

{{-- CREAR AVISO --}}
<div class="card mb-4">
    <div class="card-header">Nuevo Aviso</div>
    <div class="card-body">

        <form method="POST" action="{{ route('gestora.crear') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="tipo_servicio" class="form-control" placeholder="Tipo de servicio">
                </div>

                <div class="col-md-2">
                    <select name="urgencia" class="form-select">
                        <option value="estandar">Estándar</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="datetime-local" name="fecha" class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="text" name="franja" class="form-control" placeholder="Franja">
                </div>

                <div class="col-md-4">
                    <input type="text" name="zona" class="form-control" placeholder="Zona">
                </div>

                <div class="col-md-8">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección">
                </div>

                <div class="col-md-4">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono">
                </div>

                <div class="col-12">
                    <textarea name="descripcion" class="form-control" placeholder="Descripción"></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary">Crear Aviso</button>
                </div>
            </div>

        </form>

    </div>
</div>

{{-- LISTADO AVISOS --}}
<div class="card mb-4">
    <div class="card-header">Mis Avisos</div>
    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($avisos as $a)
                <tr>
                    <td>{{ $a->codigo }}</td>
                    <td>{{ $a->tipo_servicio }}</td>
                    <td>{{ $a->fecha }}</td>
                    <td>{{ $a->estado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

{{-- COMISIONES --}}
<div class="card">
    <div class="card-header">Mis Comisiones</div>
    <div class="card-body">

        <table class="table">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comisiones as $c)
                <tr>
                    <td>{{ $c->mes }}</td>
                    <td>{{ $c->anyo }}</td>
                    <td>{{ $c->total }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
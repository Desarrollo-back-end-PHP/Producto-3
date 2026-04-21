@extends('layouts.app')

@section('content')
<h1 class="mb-4">Liquidaciones por Gestora</h1>

<div class="card">
    <div class="card-header fw-bold">Comisiones acumuladas</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Gestora</th>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Total comisiones</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
            @forelse($liquidaciones as $liq)
                <tr>
                    <td>{{ $liq->gestora->nombre ?? 'Sin gestora' }}</td>
                    <td>{{ $liq->mes }}</td>
                    <td>{{ $liq->anyo }}</td>
                    <td>{{ number_format($liq->total, 2) }} €</td>
                    <td>
                        <span class="badge {{ $liq->estado == 'liquidada' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $liq->estado }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No hay liquidaciones registradas</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
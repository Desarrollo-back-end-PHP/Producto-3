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
                    <th>Total (€)</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
            @forelse($liquidaciones as $liq)
                <tr>

                    <td>{{ $liq->gestora->name ?? 'Sin gestora' }}</td>
                    <td>{{ $liq->mes }}</td>
                    <td>{{ $liq->anyo }}</td>
                    <td>{{ number_format($liq->total, 2) }} €</td>

                    {{-- ESTADO --}}
                    <td>
                        @if($liq->estado === 'liquidada')
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @endif
                    </td>

                    {{-- ACCIÓN --}}
                    <td>
                        @if($liq->estado === 'pendiente')
                            <form method="POST" action="{{ route('admin.comisiones.liquidar') }}">
                                @csrf

                                <input type="hidden" name="gestora_id" value="{{ $liq->gestora_id }}">
                                <input type="hidden" name="mes" value="{{ $liq->mes }}">
                                <input type="hidden" name="anyo" value="{{ $liq->anyo }}">

                                <button class="btn btn-sm btn-success">
                                    Marcar como pagado
                                </button>
                            </form>
                        @else
                            <span class="text-success fw-bold">✔ Pagado</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No hay liquidaciones registradas
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-bell me-2"></i>Historial de notificaciones</h1>

    @if($notificaciones->where('leida', 0)->count())
        <form method="POST" action="{{ route('notificaciones.leidas') }}">
            @csrf
            <button class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-check2-all me-1"></i> Marcar todas como leídas
            </button>
        </form>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:20px"></th>
                    <th>Mensaje</th>
                    <th style="width:160px">Fecha</th>
                    <th style="width:100px">Estado</th>
                </tr>
            </thead>
            <tbody>
            @forelse($notificaciones as $n)
                <tr class="{{ $n->leida ? 'text-muted' : 'fw-semibold' }}">
                    <td class="align-middle">
                        @if(!$n->leida)
                            <span class="badge bg-primary rounded-circle p-1"> </span>
                        @endif
                    </td>
                    <td class="align-middle">
                        <i class="bi bi-dot text-primary me-1"></i>{{ $n->mensaje }}
                    </td>
                    <td class="align-middle small">
                        {{ $n->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="align-middle">
                        @if($n->leida)
                            <span class="badge bg-light text-muted border">Leída</span>
                        @else
                            <span class="badge bg-primary">Nueva</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-bell-slash fs-4 d-block mb-2"></i>
                        No tienes notificaciones
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

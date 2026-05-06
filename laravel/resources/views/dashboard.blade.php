@extends('layouts.app')

@section('content')

<div class="row justify-content-center mt-3">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body py-5">
                <i class="bi bi-person-circle text-secondary mb-3" style="font-size:3rem;"></i>
                <h2 class="mb-1">Bienvenido, {{ auth()->user()->name }}</h2>
                <p class="text-muted mb-4">{{ auth()->user()->email }}</p>

                <span class="badge bg-secondary fs-6 mb-4">{{ ucfirst(auth()->user()->rol) }}</span>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="{{ route('perfil') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person me-2"></i>Mi perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

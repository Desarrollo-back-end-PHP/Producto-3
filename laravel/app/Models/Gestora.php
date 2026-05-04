<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Gestora extends User
{
    // Filtra automáticamente para que solo devuelva usuarios con rol=gestora
    protected static function booted(): void
    {
        static::addGlobalScope('gestora', function (Builder $query) {
            $query->where('rol', 'gestora');
        });

        // Al crear una gestora, el rol se asigna automáticamente
        static::creating(function ($model) {
            $model->rol = 'gestora';
        });
    }

    // Avisos creados por esta gestora
    public function avisos()
    {
        return $this->hasMany(Aviso::class, 'gestora_id');
    }

    // Comisiones de esta gestora
    public function comisiones()
    {
        return $this->hasMany(Comision::class, 'gestora_id');
    }
}

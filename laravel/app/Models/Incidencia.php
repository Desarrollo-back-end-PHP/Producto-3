<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    protected $fillable = [
        'codigo',
        'usuario_id',
        'descripcion',
        'tipo_servicio',
        'estado',
        'fecha_servicio',
        'tecnico_id',
    ];

    protected $casts = [
        'fecha_servicio' => 'datetime',
    ];

    // Relación con el usuario (cliente)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el técnico
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }
}
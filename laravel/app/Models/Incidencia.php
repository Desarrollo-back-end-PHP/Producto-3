<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'incidencias';

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }
}
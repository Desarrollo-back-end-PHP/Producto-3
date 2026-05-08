<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Especialidad;
use App\Models\User;
use App\Models\Comision;

class Aviso extends Model
{
    protected $fillable = [
        'codigo',
        'usuario_id',
        'tecnico_id',
        'especialidad_id', // 🔥 ESTE ES EL BUENO
        'urgencia',
        'fecha',
        'franja',
        'descripcion',
        'direccion',
        'telefono',
        'estado',
        'gestora_id',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    // 🔥 RELACIONES
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id');
    }

    public function comision()
    {
        return $this->hasOne(Comision::class);
    }

    // 🔥 GENERADOR DE CÓDIGO
    public static function generarCodigo(): string
    {
        $fecha = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;

        return 'AV-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
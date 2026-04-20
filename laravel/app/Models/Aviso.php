<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model {
    protected $fillable = [
        'codigo',
        'usuario_id',
        'tecnico_id',
        'tipo_servicio',
        'urgencia',
        'fecha',
        'franja',
        'descripcion',
        'direccion',
        'telefono',
        'estado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function tecnico() {
        return $this->belongsTo(Tecnico::class);
    }

    public function usuario() {
        return $this->belongsTo(User::class);
    }

    public function comision() {
        return $this->hasOne(Comision::class);
    }

    public static function generarCodigo(): string {
        $fecha = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        return 'AV-' . $fecha . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
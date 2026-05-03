<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model {
    protected $fillable = [
        'aviso_id',
        'gestora_id',
        'importe',
        'porcentaje',
        'mes',
        'anyo',
        'estado',
    ];

    public function aviso() {
        return $this->belongsTo(Aviso::class);
    }

    public function gestora() {
        return $this->belongsTo(User::class, 'gestora_id');
    }
}
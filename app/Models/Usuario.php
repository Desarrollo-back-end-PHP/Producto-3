<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Comision;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'gestora_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🔗 RELACIÓN CON COMISIONES
    public function comisiones()
    {
        return $this->hasMany(Comision::class);
    }

    // 🔗 RELACIÓN CON GESTORA (opcional)
    public function gestora()
    {
        return $this->belongsTo(Gestora::class);
    }
}
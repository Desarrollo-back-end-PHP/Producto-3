<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades'; // 🔥 ESTO ES LO QUE TE FALTA

    protected $fillable = [
        'nombre'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;

    protected $table = 'comisiones';

    protected $fillable = [
        'usuario_id',
        'monto',
        'fecha'
    ];

    // 🔗 RELACIÓN
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
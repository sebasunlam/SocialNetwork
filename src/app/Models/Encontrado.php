<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Encontrado
 */
class Encontrado extends Model
{
    protected $table = 'encontrado';

    public $timestamps = false;

    protected $fillable = [
        'contacto',
        'timestamp',
        'perdido_id',
        'perfil_id',
        'imagen_id',
        'aceptada',
        'fecha_aceptacion'
    ];

    protected $guarded = [];

        
}
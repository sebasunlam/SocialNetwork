<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cita
 */
class Cita extends Model
{
    protected $table = 'citas';

    public $timestamps = false;

    protected $fillable = [
        'fecha_solicitud',
        'acepta',
        'fecha_acepta',
        'mascota_buscando',
        'mascota_ofrecida'
    ];

    protected $guarded = [];

        
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visita
 */
class Visita extends Model
{
    protected $table = 'visitas';

    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'mascota_id',
        'perfil_id'
    ];

    protected $guarded = [];

        
}
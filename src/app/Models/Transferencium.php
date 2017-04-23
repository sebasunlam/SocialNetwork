<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transferencium
 */
class Transferencium extends Model
{
    protected $table = 'transferencia';

    public $timestamps = false;

    protected $fillable = [
        'aceptada',
        'fecha_solicitud',
        'fecha_aceptacion',
        'fecha_entrega',
        'perfil_id',
        'mascota_id'
    ];

    protected $guarded = [];

        
}
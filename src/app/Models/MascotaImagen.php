<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MascotaImagen
 */
class MascotaImagen extends Model
{
    protected $table = 'mascota_imagen';

    public $timestamps = false;

    protected $fillable = [
        'mascota_id',
        'imagen_id',
        'timestamp'
    ];

    protected $guarded = [];

        
}
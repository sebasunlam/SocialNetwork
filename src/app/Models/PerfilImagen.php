<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilImagen
 */
class PerfilImagen extends Model
{
    protected $table = 'perfil_imagen';

    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'imagen_id',
        'timestamp'
    ];

    protected $guarded = [];

        
}
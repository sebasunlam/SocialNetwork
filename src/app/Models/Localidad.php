<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Localidad
 */
class Localidad extends Model
{
    protected $table = 'localidad';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'departamento_id'
    ];

    protected $guarded = [];

        
}
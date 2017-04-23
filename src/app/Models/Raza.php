<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Raza
 */
class Raza extends Model
{
    protected $table = 'raza';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'tipo_id'
    ];

    protected $guarded = [];

        
}
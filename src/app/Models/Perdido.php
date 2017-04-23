<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perdido
 */
class Perdido extends Model
{
    protected $table = 'perdido';

    public $timestamps = false;

    protected $fillable = [
        'desde',
        'hasta',
        'lat',
        'long',
        'mascota_id'
    ];

    protected $guarded = [];

        
}
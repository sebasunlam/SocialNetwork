<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tamanio
 */
class Tamanio extends Model
{
    protected $table = 'tamanio';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'enum'
    ];

    protected $guarded = [];

        
}
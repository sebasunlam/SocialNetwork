<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincium
 */
class Provincium extends Model
{
    protected $table = 'provincia';

    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];

    protected $guarded = [];

        
}
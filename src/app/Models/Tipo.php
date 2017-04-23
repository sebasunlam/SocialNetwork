<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipo
 */
class Tipo extends Model
{
    protected $table = 'tipo';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'like_text'
    ];

    protected $guarded = [];

        
}
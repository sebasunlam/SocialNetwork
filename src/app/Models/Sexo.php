<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sexo
 */
class Sexo extends Model
{
    protected $table = 'sexo';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'enum'
    ];

    protected $guarded = [];

        
}
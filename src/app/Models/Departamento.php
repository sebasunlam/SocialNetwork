<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 */
class Departamento extends Model
{
    protected $table = 'departamento';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'provincia_id'
    ];

    protected $guarded = [];

        
}
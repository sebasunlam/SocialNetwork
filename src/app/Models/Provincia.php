<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Provincium
 */
class Provincia extends Model
{
    protected $table = 'provincia';

    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];

    protected $guarded = [];

    public function departamento(){
        return $this->hasMany('App\Models\Departamento');

    }

        
}
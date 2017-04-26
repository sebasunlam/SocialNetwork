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
        'descripcion'
    ];

    protected $guarded = [];

    public function mascota(){
        return $this->hasMany('App\Models\Mascota');
    }

    public function tipo(){
        return $this->belongsTo('App\Models\Tipo');
    }
}
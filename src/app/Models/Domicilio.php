<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Domicilio
 */
class Domicilio extends Model
{
    protected $table = 'domicilio';

    public $timestamps = false;

    protected $fillable = [
        'calle',
        'nro',
        'lat',
        'long',
        'localidad_id'
    ];

    protected $guarded = [];
    public function perfil (){
        return $this->belongsToMany('App\Models\Perfil','perfil_domicilio');
    }
        
}
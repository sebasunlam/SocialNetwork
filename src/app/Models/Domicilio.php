<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Domicilio
 */
class Domicilio extends Model
{
    protected $table = 'domicilio';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'calle',
        'numero',
        'lat',
        'long',
        'perfil_id',
        'localidad_id'
    ];

    protected $guarded = [];
    public function perfil (){
        return $this->belongsTo('App\Models\Perfil');
    }

    public function localidad(){
        return $this->belongsTo('App\Models\Localidad');
    }


        
}
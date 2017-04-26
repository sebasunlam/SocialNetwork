<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Localidad
 */
class Localidad extends Model
{
    protected $table = 'localidad';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'localidad_id'
    ];

    protected $guarded = [];

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento');
    }

    public function domicilio(){
        return $this->hasMany('App\Models\Domicilio');
    }
}
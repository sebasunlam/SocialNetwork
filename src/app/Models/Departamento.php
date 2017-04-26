<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departamento
 */
class Departamento extends Model
{
    protected $table = 'departamento';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'provincia_id'

    ];

    protected $guarded = [];

    public function provincia(){
        return $this->belongsTo('App\Models\Provincia');
    }

    public function localidad(){
        return $this->hasMany('App\Models\Localidad');
    }
        
}
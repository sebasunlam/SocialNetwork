<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perfil
 */
class Perfil extends Model
{
    protected $table = 'perfil';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'apellido',
        'nombre',
        'fechanacimiento',
        'telefono',
        'user_id',
        'sexo_id'
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function domicilio (){
        return $this->belongsToMany('App\Models\Domicilio','perfil_domicilio')->withPivot('timestamp');
    }

    public function imagen(){
        return $this->belongsToMany('App\Models\Imagen','perfil_imagen')->withPivot('timestamp');
    }

//    public function imagenes(){
//        return $this->hasMany('App\Models\Imagen');
//    }
        
}
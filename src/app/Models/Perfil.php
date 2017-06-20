<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perfil
 */
class Perfil extends Model
{
    protected $table = 'perfil';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'apellido',
        'nombre',
        'fechanacimiento',
        'telefono',
        'sexo_id',
        'user_id'
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function domicilio (){
        return $this->hasMany('App\Models\Domicilio');
    }

    public function imagen(){
        return $this->belongsToMany('App\Models\Imagen');
    }

    public function mascota(){
        return $this->hasMany('App\Models\Mascota');
    }

    public function sigue(){
        return $this->belongsToMany('App\Models\Mascota','mascota_perfil');
    }

    public function like(){
        return $this->hasMany('App\Models\PerfilLikePost');
    }
//    public function like(){
//        return $this->belongsToMany('App\Models\Post','perfil_like_post')->using('App\Model\PerfilLikePost');
//    }

    public function sexo(){
        return $this->belongsTo('App\Models\Sexo');
    }

    public function visita(){
        return $this->hasMany('App\Models\Visita');
    }

    public function encotrado(){
        $this->hasMany('App\Models\Encontrado');
    }

    public function transferencia(){
        return$this->hasMany('App\Models\Transferencia');
    }
        
}
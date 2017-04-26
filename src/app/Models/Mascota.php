<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mascotum
 */
class Mascota extends Model
{
    protected $table = 'mascota';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'dia_nacimiento',
        'mes_nacimiento',
        'anio_nacimiento',
        'adopcion',
        'pareja'

    ];

    protected $guarded = [];

    public function  post(){
        return $this->hasMany('App\Models\Post');
    }

    public function perfil(){
        return $this->belongsTo('App\Models\Perfil');
    }

    public function sexo(){
        return $this->belongsTo('App\Models\Sexo');
    }

    public function tamanio(){
        return $this->belongsTo('App\Models\Tamanio');
    }

    public function raza(){
        return $this->belongsTo('App\Models\Raza');
    }

    public function citaOfrecida(){
        return $this->hasMany('App\Models\Cita','ofrecida');
    }


    public function citaBuscando(){
    return $this->hasMany('App\Models\Cita','buscando');
    }

    public function perdido(){
        return $this->hasMany('App\Models\Perdido');
    }

    public function visita(){
        return $this->hasMany('App\Models\Visita');
    }

    public function imagen(){
        return $this->belongsToMany('App\Models\Imagen');
    }
        
}
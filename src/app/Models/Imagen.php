<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Imagen
 */
class Imagen extends Model
{
    protected $table = 'imagen';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'url',
        'extension'
    ];


    public function perfil(){
        return $this->belongsToMany('App\Models\Perfil');
    }

    public function mascota(){
        return $this->belongsToMany('App\Models\Mascota');
    }

    public function encotrado(){
        $this->hasMany('App\Models\Encontrado');
    }

    protected $guarded = [];

        
}
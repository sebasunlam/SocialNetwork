<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sexo
 */
class Sexo extends Model
{
    protected $table = 'sexo';

    protected  $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'enum'
    ];

    protected $guarded = [];

    public function perfil(){
        return $this->hasMany('App\Models\Perfil');
    }

    public function mascota(){
        return $this->hasMany('App\Models\Mascota');
    }
        
}
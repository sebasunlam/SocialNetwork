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
        return $this->belongsTo('App\User');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagen');
    }
        
}
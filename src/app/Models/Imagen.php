<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Imagen
 */
class Imagen extends Model
{
    protected $table = 'imagen';

    public $timestamps = false;

    protected $fillable = [
        'url'
    ];


    public function perfil(){
        return $this->hasMany('App\Models\Perfil');
    }

    protected $guarded = [];

        
}
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
        'url',
        'extension'
    ];


    public function perfil(){
        return $this->belongsToMany('App\Models\Perfil','perfil_imagen')->withPivot('timestamp');
    }

    protected $guarded = [];

        
}
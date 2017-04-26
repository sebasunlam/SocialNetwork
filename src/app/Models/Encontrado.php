<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Encontrado
 */
class Encontrado extends Model
{
    protected $table = 'encontrado';

    public $timestamps = true;

    protected $fillable = [
        'contacto',
        'aceptada'
    ];

    protected $guarded = [];

    public function perfil(){
        $this->belongsTo('App\Models\Perfil');
    }

    public function imagen(){
        $this->belongsTo('App\Models\Imagen');
    }

    public function perdido(){
        $this->belongsTo('App\Models\Imagen');
    }

        
}
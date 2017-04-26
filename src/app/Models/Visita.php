<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Visita
 */
class Visita extends Model
{
    protected $table = 'visitas';

    protected $primaryKey = 'id;';

    public $timestamps = true;



    protected $guarded = [];
    public function mascota(){
        return $this->belongsTo('App\Models\Mascota');
    }

    public function perfil(){
        return $this->belongsTo('App\Models\Perfil');
    }
        
}
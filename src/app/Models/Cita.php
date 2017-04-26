<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cita
 */
class Cita extends Model
{
    protected $table = 'citas';

    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'acepta'
    ];

    protected $guarded = [];

    public function buscando(){
        return $this->belongsTo('App\Models\Mascota','buscando');
    }

    public function ofrecida(){
        return $this->belongsTo('App\Models\Mascota','ofrecida');
    }

}
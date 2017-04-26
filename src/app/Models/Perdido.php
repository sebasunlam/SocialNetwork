<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Perdido
 */
class Perdido extends Model
{
    protected $table = 'perdido';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'lat',
        'long'
    ];

    protected $guarded = [];

        public function mascota(){
            return $this->belongsTo('App\Models\Mascota');
        }

    public function encotrado(){
        $this->hasMany('App\Models\Encontrado');
    }
}
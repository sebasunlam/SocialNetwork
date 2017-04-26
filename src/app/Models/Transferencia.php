<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transferencium
 */
class Transferencia extends Model
{
    protected $table = 'transferencia';

    public $timestamps = true;

    protected $fillable = [
        'aceptada'
    ];

    protected $guarded = [];

        public function perfil(){
            return $this->belongsTo('App\Models\Perfil');
        }

    public function mascota(){
        return $this->belongsTo('App\Models\Mascota');
    }
}
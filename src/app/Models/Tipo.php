<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tipo
 */
class Tipo extends Model
{
    protected $table = 'tipo';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'like_text'
    ];

    protected $guarded = [];

    public function mascota(){
        return $this->hasMany('App\Models\Mascota');
    }
        
}
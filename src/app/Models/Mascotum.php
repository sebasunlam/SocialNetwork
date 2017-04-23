<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mascotum
 */
class Mascotum extends Model
{
    protected $table = 'mascota';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'dia_nacimiento',
        'mes_nacimiento',
        'anio_nacimiento',
        'timestamp',
        'adopcion',
        'pareja',
        'raza_id',
        'tamanio_id',
        'sexo_id'
    ];

    protected $guarded = [];

        
}
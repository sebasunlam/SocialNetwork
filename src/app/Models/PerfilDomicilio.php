<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilDomicilio
 */
class PerfilDomicilio extends Model
{
    protected $table = 'perfil_domicilio';

    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'perfil_id',
        'domicilio_id'
    ];

    protected $guarded = [];

        
}
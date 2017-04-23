<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilFollowsMascotum
 */
class PerfilFollowsMascotum extends Model
{
    protected $table = 'perfil_follows_mascota';

    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'mascota_id',
        'timestamp'
    ];

    protected $guarded = [];

        
}
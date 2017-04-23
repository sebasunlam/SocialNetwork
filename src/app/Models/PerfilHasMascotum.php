<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilHasMascotum
 */
class PerfilHasMascotum extends Model
{
    protected $table = 'perfil_has_mascota';

    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'mascota_id'
    ];

    protected $guarded = [];

        
}
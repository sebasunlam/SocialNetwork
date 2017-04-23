<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PerfilLikePost
 */
class PerfilLikePost extends Model
{
    protected $table = 'perfil_like_post';

    public $timestamps = false;

    protected $fillable = [
        'perfil_id',
        'post_id',
        'timestamp',
        'coment',
        'like'
    ];

    protected $guarded = [];

        
}
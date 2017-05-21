<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 */
class Post extends Model
{
    protected $table = 'post';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'content',
        'media_id',
        'mascota_id'
    ];

    protected $guarded = [];

    public function mascota(){
        return $this->belongsTo('App\Models\Mascota','mascota_id');
    }

    public function likedBy(){
        return $this->belongsToMany('App\Models\Perfil','perfil_like_post')->using('App\Models\PerfilLikePost')->withPivot('created_at');
    }

    public function media(){
        return $this->belongsTo('App\Models\Media');
    }

        
}
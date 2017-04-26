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
        'content'
    ];

    protected $guarded = [];

    public function mascota(){
        return $this->belongsTo('App\Model\Mascota');
    }

    public function likedBy(){
        return $this->belongsToMany('App\Model\Perfil','perfil_like_post')->using('App\Models\PerfilLikePost');
    }

    public function media(){
        return $this->belongsTo('App\Model\Media');
    }

        
}
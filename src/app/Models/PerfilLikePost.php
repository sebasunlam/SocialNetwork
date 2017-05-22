<?php
/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 25/04/2017
 * Time: 19:16
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PerfilLikePost extends Model
{
    protected $table = 'perfil_like_post';

    public $timestamps = true;


    protected $fillable = [
        'coment',
        'like',
        'perfil_id',
        'post_id'
    ];

    protected $guarded = [];

    public function post(){
        return $this->belongsTo('App\Models\Post','post_id');
    }

    public function perfil(){
        return $this->belongsTo('App\Models\Perfil','perfil_id');
    }


}
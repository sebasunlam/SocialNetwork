<?php
/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 25/04/2017
 * Time: 19:16
 */

namespace App\Models;


class PerfilLikePost extends Model
{
    protected $table = 'perfil_like_post';

    public $timestamps = true;


    protected $fillable = [
        'coment',
        'like'
    ];

    protected $guarded = [];



}
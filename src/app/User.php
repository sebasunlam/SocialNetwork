<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = 'user';

    public $timestamps = false;

    protected $fillable = [
        'email',
        'password',
        'fechaCreacion',
        'facebookId',
        'facebookToken',
        'facebookRefreshToken',
        'googleId',
        'googleToken',
        'googleRefreshToken'
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
}

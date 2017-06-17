<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;

    protected $table = 'user';

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $fillable = [
        'email',
        'password'
    ];

    public function perfil()
    {
        return $this->hasOne('App\Models\Perfil');
    }

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

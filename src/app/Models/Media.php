<?php
/**
 * Created by PhpStorm.
 * User: Sebastian
 * Date: 21/05/2017
 * Time: 4:19
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
/*
 * Class PostMedia
 */
class Media extends Model
{
    protected $table = 'postmedia';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'url',
        'local',
        'extension'
    ];

    protected $guarded = [];

    public function post(){
        return $this->hasMany('App\Models\Post');
    }
}
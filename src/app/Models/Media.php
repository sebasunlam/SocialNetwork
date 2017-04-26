<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aedium
 */
class Media extends Model
{
    protected $table = 'media';

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

    public function mediaType(){
        return $this->belongsTo('App\Models\MediaType');
    }

        
}
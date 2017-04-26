<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaType
 */
class MediaType extends Model
{
    protected $table = 'media_type';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'enum'
    ];

    protected $guarded = [];

    public function media(){
        return $this->hasMany('App\Models\Media');
    }

        
}
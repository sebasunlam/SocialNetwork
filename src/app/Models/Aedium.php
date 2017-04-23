<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aedium
 */
class Aedium extends Model
{
    protected $table = 'media';

    public $timestamps = false;

    protected $fillable = [
        'url',
        'media_type_id',
        'local'
    ];

    protected $guarded = [];

        
}
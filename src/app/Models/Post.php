<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 */
class Post extends Model
{
    protected $table = 'post';

    public $timestamps = false;

    protected $fillable = [
        'content',
        'timestamp',
        'media_id',
        'shared_post_id'
    ];

    protected $guarded = [];

        
}
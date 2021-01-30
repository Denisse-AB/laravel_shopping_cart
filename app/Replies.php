<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comments_id', 'user_id', 'name', 'reply',
    ];

    protected $casts = [
        'created_at' => 'datetime:m-d-Y h:i A',
        'updated_at' => 'datetime:M-j-y h:i A',
    ];

}

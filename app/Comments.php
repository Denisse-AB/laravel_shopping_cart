<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'item_id', 'name', 'comment',
    ];

    protected $casts = [
        'created_at' => 'datetime:m-d-Y h:i A',
        'updated_at' => 'datetime:M-j-y h:i A',
    ];
}

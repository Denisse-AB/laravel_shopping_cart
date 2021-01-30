<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku', 'name', 'price', 'image', 'discount', 'category', 'description',
    ];

     public $timestamps = false;
}

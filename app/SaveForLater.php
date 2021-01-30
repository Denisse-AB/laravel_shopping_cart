<?php

namespace App;

use App\Items;
use Illuminate\Database\Eloquent\Model;

class SaveForLater extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'item_id'
    ];
     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    public function items()
    {
        return $this->hasMany(Items::class); //check
    }
}

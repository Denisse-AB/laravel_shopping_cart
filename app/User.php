<?php

namespace App;

use App\Replies;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'tel', 'password', 'address', 'city', 'state', 'zip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Orders::class)->orderBy('created_at', 'DESC');

    }

    public function saveForLater()
    {
        return $this->hasOne(SaveForLater::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->orderBy('created_at', 'DESC');
    }

    public function replies()
    {
        return $this->hasMany(Replies::class)->orderBy('created_at', 'DESC');
    }
}


<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'subscriber', 'featured', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }

    public function isSubscriber()
    {
        return $this->subscriber == 1 ? true : false;
    }

    public function isFeatured()
    {
        return $this->featured == 1 ? true : false;
    }

}

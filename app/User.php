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

    /**
     * Get the users comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the users posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Get the users notifications.
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

}

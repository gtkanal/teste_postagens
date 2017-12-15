<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Comment extends Model
{
    protected $fillable = ['comment', 'post_id', 'user_id'];

    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function formattedDate()
    {

        return $this->created_at->format('d/m/Y h:m:s');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Comment extends Model
{
    protected $fillable = [
        'content', 'likes', 'dislikes'
    ];

    // Define the relationship with the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

}

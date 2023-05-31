<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;


class Post extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function dislikes(): HasMany
    {
        return $this->hasMany(Dislike::class);
    }

    public function likedByUser()
    {
        return $this->likes()->where('user_id', auth()->user()->id)->exists();
    }

    public function dislikedByUser()
    {
        return $this->dislikes()->where('user_id', auth()->user()->id)->exists();
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected $fillable = [

        'image',
    ];

}

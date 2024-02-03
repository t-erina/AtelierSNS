<?php

namespace App\Models\Posts;

use App\Models\Users\User;
use App\Models\Posts\Comment;
use App\Models\Posts\Like;
use App\Models\Posts\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'post',
        'tag',
        'image',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getTimelinePosts($user_id, $following_id)
    {
        if (!empty($following_id)) {
            return $this->with('user', 'likes', 'images')->whereIn('user_id', $following_id)->orWhere('user_id', $user_id)->latest('created_at')->get();
        } else {
            return $this->with('user', 'likes', 'images')->where('user_id', '=', $user_id)->latest('created_at')->get();
        }
    }

    public function getPosts($post_id)
    {
        return $this->with('user', 'likes', 'images')->whereIn('id', $post_id)->latest('created_at')->get();
    }

    public function getPostDetail($post_id)
    {
        return $this->with('user', 'comments', 'likes', 'images')->where('id', "=", $post_id)->first();
    }

    public function deletePost($post_id)
    {
        return $this->find($post_id)->delete();
    }

    public function searchPosts($keywords)
    {
        return $this->where('post', 'like', '%' . $keywords . '%')->orWhere('tag', 'like', '%' . $keywords . '%')->latest('updated_at')->take(20)->get();
    }
}

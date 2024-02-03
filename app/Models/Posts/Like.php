<?php

namespace App\Models\Posts;

use App\Models\Posts\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getLikeList($user_id)
    {
        return $this->where('user_id', '=', $user_id)->pluck('post_id');
    }

    public function storeLikes($auth_id, $post_id)
    {
        $this->create([
            'user_id' => $auth_id,
            'post_id' => $post_id,
        ]);
    }

    public function deleteLikes($auth_id, $post_id)
    {
        $this->where('user_id', $auth_id)->where('post_id', $post_id)->first()->delete();
    }
}

<?php

namespace App\Models\Posts;

use App\Models\Posts\Post;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storeComment($post_id, $comment)
    {
        return $this->create([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
            'comment' => $comment,
        ]);
    }

    public function updateComment($comment_id, $comment)
    {
        return $this->find($comment_id)->update([
            'comment' => $comment,
        ]);
    }

    public function deleteComment($comment_id)
    {
        return $this->find($comment_id)->delete();
    }
}

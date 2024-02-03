<?php

namespace App\Models\Follows;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Follow extends Model
{
    protected $table = 'follows';

    protected $fillable = [
        'following_id',
        'followed_id',
    ];

    public function getFollowingUsers($user_id)
    {
        return $this->where('following_id', $user_id)->pluck('followed_id', 'id');
    }

    public function getFollowedUsers($user_id)
    {
        return $this->where('followed_id', $user_id)->pluck('following_id', 'id');
    }

    public function storeFollow($followed_id)
    {
        return $this->create([
            'following_id' => Auth::id(),
            'followed_id' => $followed_id,
        ]);
    }

    public function deleteFollow($auth_id, $user_id)
    {
        $followed_user = $this->where('following_id', $auth_id)->where('followed_id', $user_id)->first();
        return $this->findOrFail($followed_user->id)->delete();
    }
}

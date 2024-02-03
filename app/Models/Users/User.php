<?php

namespace App\Models\Users;

use App\Models\Posts\Comment;
use App\Models\Posts\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'user_name',
        'email',
        'password',
        'profile',
        'icon',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'following_id')->withTimestamps();
    }

    public function followed()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'followed_id')->withTimestamps();
    }

    public function getUserDetail($user_id)
    {
        return $this->find($user_id);
    }

    public function getUsers($user_id)
    {
        return $this->whereIn('id', $user_id)->get();
    }

    public function updateUsername($username){
        return $this->find(Auth::id())->update([
            'user_name' => $username,
        ]);
    }

    public function updateEmail($email)
    {
        return $this->find(Auth::id())->update([
            'email' => $email,
        ]);
    }

    public function updatePassword($password)
    {
        return $this->find(Auth::id())->update([
            'password' => $password,
        ]);
    }

    public function searchUsers($keywords)
    {
        return $this->where('user_name', 'like', '%' . $keywords . '%')->take(20)->get();
    }
}

<?php

namespace App\Models\Posts;

use App\Models\Posts\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    protected $table = 'post_images';

    protected $fillable = [
        'user_id',
        'post_id',
        'file_name',
    ];

    public function post (){
        return $this->belongsTo(Post::class);
    }

    public function storeImage($post_id, $imagePath) {
        return $this->create([
                    'user_id' => Auth::id(),
                    'post_id' => $post_id,
                    'file_name' => $imagePath,
        ]);
    }

    public function getImage($post_id){
        return $this->where('post_id', '=', $post_id)->get();
    }

    public function deleteImage($post_id){
        return $this->where('post_id', '=', $post_id)->delete();
    }
}

<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Follows\Follow;
use App\Models\Posts\Image;
use App\Models\Posts\Like;
use App\Models\Posts\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $auth_id = Auth::id();
        $getFollows = new Follow;
        $following_id = $getFollows->getFollowingUsers($auth_id);
        $following_check = $following_id->flip();
        $getPosts = new Post;
        $posts = $getPosts->getTimelinePosts($auth_id, $following_id);
        $getLikes = new Like;
        $auth_likePosts_id = $getLikes->getLikeList($auth_id);
        $likePost_check = $auth_likePosts_id->flip();
        return view('posts.top', compact('posts', 'following_id', 'following_check', 'likePost_check'));
    }

    public function showPostForm()
    {
        return view('posts.post_store-form');
    }

    public function showDetail($post_id)
    {
        $auth_id = Auth::id();
        $getDetail = new Post;
        $post = $getDetail->getPostDetail($post_id);
        return view('posts.post_detail', compact('auth_id', 'post'));
    }

    public function store(PostFormRequest $request)
    {
        $validated = $request->validated();
        $auth_id = Auth::id();
        $tag = str_replace('　', ' ', $validated['tag']);
        $validated['user_id'] = $auth_id;

        DB::beginTransaction();
        try {
            $created = Post::create([
                'post' => $validated['post'],
                'user_id' => $auth_id,
                'tag' => $tag,
            ]);
            $post_id = $created->id;

            if (isset($validated['image'])) {
                $dir = 'post_images/';
                $imageName = $validated['image']->getClientOriginalName();
                $imagePath = time() . $imageName;

                $validated['image']->storeAs('public/' . $dir, $imagePath);

                $getImage = new Image;
                $getImage->storeImage($post_id, $imagePath);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect(route('top'));
    }

    public function postUpdateForm($post_id)
    {
        $getPosts = new Post;
        $post = $getPosts->getPostDetail($post_id);
        return view('posts.post_update-form', compact('post'));
    }

    public function update(PostFormRequest $request)
    {
        $post_id = $request->input('post_id');
        $validated = $request->validated();
        $newTag = str_replace('　', ' ', $validated['tag']);

        DB::beginTransaction();
        try {
            Post::find($post_id)->update([
                'post' => $validated['post'],
                'tag' =>  $newTag,
            ]);

            if (isset($validated['image'])) {
                $dir = 'post_images/';
                $imageName = $validated['image']->getClientOriginalName();
                $imagePath = time() . $imageName;

                $validated['image']->storeAs('public/' . $dir, $imagePath);

                $getImage = new Image;
                $images = $getImage->getImage($post_id);

                if (!empty($images)) {
                    $getImage->deleteImage($post_id);
                    foreach ($images as $image) {
                        Storage::disk('public')->delete($dir . $image->file_name);
                    }
                }

                $getImage->storeImage($post_id, $imagePath);
            }
            $request->session()->flash('message', '変更を保存しました');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect(route('top'));
    }

    public function delete(Request $request)
    {
        $post_id = $request->route('post_id');
        DB::beginTransaction();
        try {
            $getImage = new Image;
            $images = $getImage->getImage($post_id);

            if (!empty($images)) {
                $dir = 'post_images/';
                $getImage->deleteImage($post_id);
                foreach ($images as $image) {
                    Storage::disk('public')->delete($dir . $image->file_name);
                }
            }

            $post = new Post;
            $post->deletePost($post_id);

            DB::commit();
            $request->session()->flash('message', '投稿を削除しました');
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect(route('top'));
    }
}

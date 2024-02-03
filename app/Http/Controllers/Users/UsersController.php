<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileFormRequest;
use App\Models\Posts\Post;
use App\Models\Follows\Follow;
use App\Models\Posts\Like;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($user_id)
    {
        $auth_id = Auth::id();
        $getUsers = new User;
        $users = $getUsers->getUserDetail($user_id);
        $getFollows = new Follow;

        // other user
        $userFollowing_id =
            $getFollows->getFollowingUsers($user_id);
        $userListUsers = $getUsers->getUsers($userFollowing_id);
        $getPosts = new Post;
        $posts = $getPosts->getTimelinePosts($user_id, null);
        $getLikes = new Like;
        $likePosts_id = $getLikes->getLikeList($user_id);
        $likePosts = $getPosts->getPosts($likePosts_id);

        // auth
        $following_id = $getFollows->getFollowingUsers($auth_id);
        $following_check = $following_id->flip();
        $auth_likePosts_id = $getLikes->getLikeList($auth_id);
        $likePost_check = $auth_likePosts_id->flip();
        return view('users.profile', compact('users', 'userListUsers', 'posts', 'likePosts', 'following_id', 'following_check', 'likePost_check'));
    }

    public function plofileEditForm()
    {
        $users = Auth::user();
        return view('users.profile_edit', compact('users'));
    }

    public function updateProfile(ProfileFormRequest $request)
    {
        $validated = $request->validated();
        $auth_id = Auth::id();
        $icon = Auth::user()->icon;

        DB::beginTransaction();
        try {
            if (isset($validated['icon'])) {
                $dir = 'user_icon/';
                $imageName = $validated['icon']->getClientOriginalName();
                $imagePath = time() . $imageName;

                if (!empty($icon)) {
                    Storage::disk('public')->delete($dir . $icon);
                }

                $validated['icon']->storeAs('public/' . $dir, $imagePath);

                User::where('id', $auth_id)->update([
                    'icon' => $imagePath,
                ]);
            }

            User::where('id', $auth_id)->update([
                'profile' =>  $validated['profile'],
            ]);

            DB::commit();
            $request->session()->flash('message', '変更を保存しました');
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect(route('profile', $auth_id));
    }
}

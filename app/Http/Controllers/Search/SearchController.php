<?php

namespace App\Http\Controllers\search;

use App\Http\Controllers\Controller;
use App\Models\Follows\Follow;
use App\Models\Posts\Post;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $keywords = $request->input('keywords');

        $user = new User;
        $userListUsers = $user->searchUsers($keywords);
        $post = new Post;
        $posts = $post->searchPosts($keywords);

        $getFollows = new Follow;
        $following_id = $getFollows->getFollowingUsers(Auth::id());
        $following_check = $following_id->flip();

        return view('search.search_result', compact('userListUsers', 'posts', 'following_check'));
    }
}

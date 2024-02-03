<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Posts\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $auth_id = Auth::id();
        $post_id = $request->post_id;
        $likes = new Like;
        $likes->storeLikes($auth_id, $post_id);

        return response()->json();
    }

    public function delete(Request $request)
    {
        $auth_id = Auth::id();
        $post_id = $request->post_id;
        $likes = new Like;
        $likes->deleteLikes($auth_id, $post_id);

        return response()->json();
    }
}

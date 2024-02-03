<?php

namespace App\Http\Controllers\Follows;

use App\Http\Controllers\Controller;
use App\Models\Follows\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $followed_id = $request->user_id;
        $follows = new Follow;
        $follows->storeFollow($followed_id);
        return response()->json();
    }

    public function delete(Request $request)
    {
        $auth_id = Auth::id();
        $user_id = $request->user_id;
        $follows = new Follow;
        $follows->deleteFollow($auth_id, $user_id);

        return response()->json();
    }
}

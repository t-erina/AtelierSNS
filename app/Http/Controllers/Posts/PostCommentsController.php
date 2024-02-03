<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentFormRequest;
use App\Models\Posts\Comment;
use Illuminate\Http\Request;


class PostCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(PostCommentFormRequest $request){
        $post_id = $request->route('post_id');
        $validated = $request->validated();
        $comment = $validated['comment'];

        $storeComment = new Comment;
        $storeComment->storeComment($post_id, $comment);
        return back();
    }

    public function update(PostCommentFormRequest $request)
    {
        $comment_id = $request->route('comment_id');
        $validated = $request->validated();
        $comment = $validated['comment'];

        $getComment = new Comment;
        $getComment->updateComment($comment_id, $comment);
        $request->session()->flash('message', '変更を保存しました');
        return back();
    }

    public function delete(Request $request)
    {
        $comment_id = $request->route('comment_id');
        $getComment = new Comment;
        $getComment->deleteComment($comment_id);
        $request->session()->flash('message', 'コメントを削除しました');
        return back();
    }
}

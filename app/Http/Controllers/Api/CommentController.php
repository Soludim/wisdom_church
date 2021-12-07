<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Post;
use App\Sermon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CommentController extends Controller
{

    // Store a newly created comment in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'commentable_id' => ['required', 'integer'],
            'commentable_type' => ['required', 'string'],
            'body' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $comment = new Comment();
        $comment->body = $request->input('body');
        $comment->commentable_id = $request->input('commentable_id');
        $comment->commentable_type = $request->input('commentable_type');
        $comment->user_id = $request->user()->id;

        if ($comment->save()) {
            $newComment = Comment::with('user')->find($comment->id);
            return response()->json(["data" => $newComment, "message" => "comment added"]);
        }
    }

    public function post_comments($id)
    {
        $post = Post::find($id);
        if ($post == null) {
            return response()->json(["message" => "post does not exist"]);
        }
        $comments = Comment::where('commentable_type', 'App\Post')
        ->where('commentable_id', $id)->withCount('replies')->with(['user','replies.user'])->get();

        return response()->json(["data" => $comments]);
    }

    public function edit_comment(Request $request, $id)
    {

        $comment = Comment::find($id);

        if ($comment == null) {
            return response()->json(["message" => "comment does not exist"]);
        }

        if ($request->user()->id != $comment->user_id) {
            return response()->json(["message" => "Unauthaurized to edit this comment"]);
        }

        $val = Validator::make($request->all(), [
            'body' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }


        $comment->body = $request->input('body');
        $comment->update();
        return response()->json(["data" => $comment, "message" => "Comment updated successfully"]);
    }

    public function del_comment(Request $request, $id)
    {

        $comment = Comment::find($id);

        if ($comment == null) {
            return response()->json("comment does not exist");
        }

        if ($request->user()->id != $comment->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this comment"]);
        }

        foreach ($comment->replies as $reply) {
            $reply->likes()->delete();
        }
        $comment->replies()->delete();
        $comment->likes()->delete();
        $comment->delete();
        return response()->json(["data" => $comment, "message" => "Comment deleted successfully"]);
    }

    public function sermon_comments($id)
    {
        $sermon = Sermon::find($id);
        if ($sermon == null) {
            return response()->json("sermon does not exist");
        }
        return response()->json(["data" => $sermon->comments]);
    }
}

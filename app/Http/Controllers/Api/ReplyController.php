<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Reply;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'body' => ['required', 'string'],
            'comment_id' => ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }


        $reply = new Reply();
        $reply->body = $request->input('body');
        $reply->comment_id = $request->input('comment_id');
        $reply->user_id = $request->user()->id;


        if ($reply->save()) {
            $newReply = Reply::with('user')->find($reply->id);
            return response()->json(["data" => $newReply, "message" => "Reply to message was successful"]);
        }
    }

    public function comment_replies($id)
    {
        $comment = Comment::find($id);
        if ($comment == null) {
            return response()->json(["message" => "comment does not exist"]);
        }
        return response()->json(["data" => $comment->replies]);
    }

    public function update_reply(Request $request, $id)
    {
        $reply = Reply::find($id);

        if ($reply == null) {
            return response()->json(["message" => "Reply does not exist"]);
        }

        $val = Validator::make($request->all(), [
            'body' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        
        if ($request->user()->id != $reply->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this reply"]);
        }

        $reply->body = $request->input('body');
        $reply->update();
        return response()->json(["data" => $reply, "message" => "Reply updated successfully"]);
    }

    public function delete_reply(Request $request, $id)
    {
        $reply = Reply::find($id);

        if ($reply == null) {
            return response()->json(["message" => "Reply does not exist"]);
        }

        if ($request->user()->id != $reply->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this reply"]);
        }

        $reply->likes()->delete();
        $reply->delete();
        return response()->json(["data" => $reply, "message" => "Reply deleted successfully"]);
    }
}

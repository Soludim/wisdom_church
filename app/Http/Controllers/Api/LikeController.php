<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Like;
use App\Post;
use App\Sermon;
use App\Comment;
use App\Reply;
use Illuminate\Support\Facades\Validator;


class LikeController extends Controller
{
    public function like(Request $request)
    {
        $val = Validator::make($request->all(), [
            'liketable_id' => ['required', 'integer'],
            'liketable_type' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        if ($request->input('liked')) {
            $like = Like::find($request->input('liked'));

            if ($like == null) {
                return response()->json(["message" => "No Like found"]);
            }

            if ($request->user()->id != $like->user_id) {
                return response()->json(["message" => "Unauthaurized to dislike"]);
            }

            $like->delete();
            return response()->json(["data" => $like, "message" => "Like removed successsfully"]);
        } else {

            $like = new Like();
            $like->user_id = $request->user()->id;
            $like->liketable_id = $request->input('liketable_id');
            $like->liketable_type = $request->input('liketable_type');

            if ($like->save()) {
                return response()->json($like);
            }
        }
    }


    //get all likes of a specified comment
    public function comment_likes($id)
    {
        $comment = Comment::find($id);
        if ($comment == null) {
            return response()->json(["message" => "comment does not exist"]);
        }
        return response()->json(["data" => $comment->likes]);
    }

    //get all likes of a specified reply
    public function reply_likes($id)
    {
        $reply = Reply::find($id);
        if ($reply == null) {
            return response()->json(["message" => "reply does not exist"]);
        }
        return response()->json(["data" => $reply->likes]);
    }
}

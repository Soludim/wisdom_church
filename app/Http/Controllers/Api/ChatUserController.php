<?php

namespace App\Http\Controllers\Api;

use App\ChatUser;
use App\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ChatUserController extends Controller
{
    // all users for a specified chat
    public function index($id)
    {

        $chat = Chat::find($id);
        if ($chat == null) {
            return response()->json(["message" => "chat dont exist"]);
        }

        return response()->json(["data" => $chat->chatUsers, "message" => "listing of all user chats was successful"]);
    }

    // listing of chats a user belongs
    public function myChats($id)
    {
        $user_chats =  ChatUser::with(['chat'])->where("user_id", $id)->get();
        return response()->json(["data" => $user_chats]);
    }

    // add user to a specified chat
    public function store(Request $request)
    {

        $val = Validator::make($request->all(), [
            'chat_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer', 'unique:chat_users']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $chatUser = new ChatUser();
        $chatUser->chat_id = $request->input('chat_id');
        $chatUser->user_id = $request->input('user_id');

        if ($chatUser->save()) {
            return response()->json(["data" => $chatUser, "message" => "User added to chat successfully"]);
        }
    }

    public function addOrRemove(Request $request)
    {
        $val = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'chat_id' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

      if($request->input('status') == 1) {
        //user is already a member  //removing user from group
          $chat = Chat::find($request->input('chat_id'));
        if ($chat == null) {
            return response()->json(["message" => "Chat does not exist"]);
        }


        if ($request->user()->role_id != 1 && $request->user()->id != $chat->user_id) {
            return response()->json(["message" => "Unauthaurized to remove users"]);
        }

        $user = $chat->chatUsers()->where('user_id', $request->input('user_id'))->first();

        if ($user == null) {
            return response()->json(["message" => "User not found in chat"]);
        }

        $user->delete();
      } else {
          //user is not a member //adding new user to the group

        $chatUser = new ChatUser();
        $chatUser->chat_id = $request->input('chat_id');
        $chatUser->user_id = $request->input('user_id');

        $chatUser->save();
      }
    }

    // remove user from a specified chat
    public function remove(Request $request, $id)
    {
        $chat = Chat::find($id);
        if ($chat == null) {
            return response()->json(["message" => "Chat does not exist"]);
        }


        $val = Validator::make($request->all(), [
            'user_id' => ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        if ($request->user()->role_id != 1 && $request->user()->id != $chat->user_id) {
            return response()->json(["message" => "Unauthaurized to remove users"]);
        }

        $user = $chat->chatUsers()->find($request->input('user_id'));

        if ($user == null) {
            return response()->json(["message" => "User not found in chat"]);
        }

        $user->delete();

        return response()->json(["data" => $chat, "message" => "User removed from chat successfully"]);
    }

}

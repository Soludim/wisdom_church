<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\ChatUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'destroy', 'update', 'show']);
    }


    // Display a listing of all chats.
    public function index()
    {
        $chats = Chat::all();
        return response()->json(["data" => $chats, "message" => "all chats"]);
    }

    // Store a newly created chat in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50', 'unique:chats'],
            'info' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $chat = new Chat();
        $chat->name = $request->input('name');
        $chat->info = $request->input('info');
        $chat->user_id = $request->user()->id;

        if ($chat->save()) {
            $chatUser = new ChatUser();
            $chatUser->chat_id = $chat->id;
            $chatUser->user_id = $request->user()->id;
            $chatUser->save();
            return response()->json(["data" => $chat, "message" => $chat->name . " chat room created successfully"]);
        }
    }

    // Display the specified chat.
    public function show($id, Request $request)
    {
        $chat = Chat::with(['chatUsers', 'chatMsgs.user'])->find($id);
        if ($chat == null) {
            return response()->json(["message" => "chat does not exist"]);
        }
         //swap to put authenticated user last on the list
         for ($i = 0; $i < count($chat->chatUsers); $i++) {
            if ($chat->chatUsers[$i]->user_id === $request->user()->id) {
                $last_user = $chat->chatUsers[count($chat->chatUsers) - 1];
                $chat->chatUsers[count($chat->chatUsers) - 1] = $chat->chatUsers[$i];
                $chat->chatUsers[$i] = $last_user;
                break;
            }
        }
        return response()->json(["data" => $chat]);
    }


    // Update the specified chat in storage
    public function update(Request $request, $id)
    {
        $chat = Chat::find($id);

        if ($chat == null)
            return response()->json(["message" => "chat does not exist"]);

        if ($request->user()->role_id != 1 && $request->user()->id != $chat->user_id) {
            return response()->json(["message" => "Unauthaurized to edit this chat"]);
        }


        $chat->name = $request->input('name');
        $chat->info = $request->input('info');

        $chat->update();
        return response()->json(["data" => $chat, "message" => "Update was successful"]);
    }

    // Remove the specified chat from storage.
    public function destroy(Request $request, $id)
    {
        $chat = Chat::find($id);
        if ($chat == null) {
            return response()->json(["message" => "chat does not exist"]);
        }


        if ($request->user()->role_id != 1 && $request->user()->id != $chat->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this chat"]);
        }

        $chat->chatUsers()->delete();
        $chat->chatMsgs()->delete();
        $chat->delete();
        return response()->json(["data" => $chat, "message" => $chat->name . " chat deleted successfully"]);
    }

}

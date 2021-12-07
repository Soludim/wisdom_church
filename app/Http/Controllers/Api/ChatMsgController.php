<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\ChatMsg;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatMsgController extends Controller
{
    // all msgs for a specified chat
    public function index($id) {

        $chat = Chat::find($id);
        if ($chat == null) {
            return response()->json(["message"=>"chat does not exist."]);
        }
        return response()->json(["data"=>$chat->chatMsgs]);
    }


    // add chatmsg to a specified chat
    public function store(Request $request) {

        $val = Validator::make($request->all(), [
            'msg' => ['required'],
            'chat_id' => ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json(["error"=>$val->errors()]);
        }
        $chatMsg = new ChatMsg();
        $chatMsg->msg = $request->input('msg');
        $chatMsg->chat_id = $request->input('chat_id');
        $chatMsg->user_id = $request->user()->id;

        if ($chatMsg->save()) {
            return response()->json(["data"=>$chatMsg, "message"=>"Msg added to chat successfully"]);
        }
    }

    // remove chat msg from a specified chat
    public function remove(Request $request, $id) {

        $chatMsg = ChatMsg::find($id);
        if ($chatMsg == null) {
            return response()->json(["message"=>"Message does not exist"]);
        }

        if ($request->user()->role_id != 1 && $request->user()->id != $chatMsg->user_id) {
            return response()->json(["message"=>"Unauthaurized to delete this chat message"]);
        }

        $chatMsg->delete();
        
        return response()->json(["data"=>$chatMsg, "message"=>"Message deleted successfully"]);

    }
}

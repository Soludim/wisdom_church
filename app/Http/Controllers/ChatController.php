<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\ChatMsg;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use Pusher\Pusher;
use App\Events\ChaEvent;
use App\Events\ChatEvent;

class ChatController extends Controller
{
    public function index()
    {        //get all user's chat groups
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);


            $response = json_decode($client->get('api/user_chat/' . Auth::user()->id)->getBody());
            return view('pages.dashboard.chat', ['data' => $response->data]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function show($id)
    {
        //TODO
    }

    public function chatRoom($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);


            $response = json_decode(
                $client->get('api/chat/' . Crypt::decrypt($id)
                    . '?api_token=' . Auth::user()->api_token)->getBody()
            );
            $users = json_decode($client->get('api/user')->getBody());
            return view('pages.dashboard.chat_room', ['data' => $response->data, 'users' => $users->data]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:chats'],
            'info' => ['required', 'string']
        ]);
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $client->post(
                'api/chat?api_token=' . Auth::user()->api_token,
                ['form_params' =>
                [
                    'name' => $request->input('name'),
                    'info' => $request->input('info')
                ]]
            );
            return redirect()->route('chat.index');
        } catch (ClientException $th) {
            return back();
        }
    }

    public function postMsg(Request $request)
    {
        $msg = new ChatMsg();
        $msg->user_id = Auth::id();
        $msg->chat_id = $request->group_id;
        $msg->msg = $request->message;
        $msg->save();

        // pusher
        $data = ['from' => Auth::id(), 'to' => $request->group_id, 'message' => $request->message]; // sending from and to id when pressed enter
        event(new ChatEvent($data));

        return response()->json($data);
    }




    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $res = json_decode($client->delete('api/chat/' . $id . '?api_token=' . Auth::user()->api_token)->getBody());
            return  redirect()->route('chat.index');
        } catch (ClientException $th) {
            return back();
        }
    }
}

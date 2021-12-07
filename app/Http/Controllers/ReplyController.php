<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ReplyController extends Controller
{

    public function store(Request $request)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $client->post('api/reply?api_token=' . Auth::user()->api_token, ['form_params' =>  [
                'body' => $request->input('body'),
                'comment_id' => $request->input('comment')
            ]]);
            return  redirect(url()->previous());
        } catch (ClientException $th) {
            return back();
        }
    }

    public function destroy($id)
    {
        //
    }
}

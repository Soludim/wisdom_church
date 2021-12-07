<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class TestimonyController extends Controller
{
    public function index($page = 1)
    {

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/testimony?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/testimony?page=' . Crypt::decrypt($page))->getBody());

            return view('pages.dashboard.testimonies', ['data' => $response->data]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $res = json_decode($client->post('api/testimony?api_token=' . Auth::user()->api_token, ['form_params' =>  [
                'content' => $request->input('content')
            ]])->getBody());

            $notification = array(
                'message' => $res->message,
                'alert_type' => $res->status
            );

            return  back()->with('message', $notification);
        } catch (\Throwable $th) {
            $notification = array(
                'message' => "Something went wrong",
                'alert_type' => "error"
            );
            return back()->with('message', $notification);
        }
    }



    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->delete('api/testimony/' . $id . '?api_token=' . Auth::user()->api_token);
            return  redirect()->route('testimony');
        } catch (ClientException $th) {
            return back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class DashboardController
{

    public function index()
    {
        try {
            if (!in_array(Auth::user()->role_id, \config('app.permissions')))
               return \redirect()->route('posts');
            $client = new Client(['base_uri' => config('app.api_base')]);
            $endpoint = 'api/dash_index?api_token=' . Auth::user()->api_token;

            $response = json_decode($client->get($endpoint)->getBody());
            return view('pages.dashboard.index', ['data'=>$response]);
        } catch (ClientException $th) {
            return back();
        }
        
    }
}

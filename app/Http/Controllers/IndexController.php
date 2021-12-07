<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index()
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $response = json_decode($client->get('api/index')->getBody());
            return view('pages.index', ['data' => $response->data]);
        } catch (ClientException $th) {
            echo ($th);
        }
    }


    public function about()
    {
        //done        leaders
        //done        latest event
        //undone      chuch achievements
        //undone      History
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/about')->getBody());

            return view('pages.about', ['data' => $response]);
        } catch (ClientException $th) {
            return back();
        }
    }
}

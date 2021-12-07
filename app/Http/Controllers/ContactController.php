<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ContactController extends Controller
{
    public function index() {
        return view('pages.contact');
    }

    public function store(Request $request)
    {
        //method sends mail
        $data = [
            [
                'name' => 'name',
                'contents' => $request->input('name')
            ],
            [
                'name' => 'email',
                'contents' => $request->input('email')
            ],
            [
                'name' => 'subject',
                'contents' => $request->input('subject')
            ],
            [
                'name' => 'message',
                'contents' => $request->input('message')
            ]
        ];
       
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $client->post('api/sendmail', ['formdata' => $data]);
            $notification = array(
                'message' => $res->message,
                'alert_type' => $res->status
            );

            return  back()->with('message', $notification);
        } catch (ClientException $th) {
            $notification = array(
                'message' => "Sending mail was unsuccessful",
                'alert_type' => "error"
            );

            return  back()->with('message', $notification);
        }
    }
}

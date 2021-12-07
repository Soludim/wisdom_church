<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class SermonController extends Controller
{
    public function dindex($page = 1)
    {

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/sermon?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/sermon?page=' . Crypt::decrypt($page))->getBody());

            return view('pages.dashboard.sermons', ['data' => $response->sermons]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function index($page = 1)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/sermon?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/sermon?page=' . Crypt::decrypt($page))->getBody());


            return view('pages.sermons', ['data' => $response]);
        } catch (ClientException $th) {
            return back();
        }
    }


    public function create()
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $response = json_decode($client->get('api/speakers')->getBody());

            return view(
                'pages.dashboard.create_edit_sermon',
                ['sermon' => null, 'systemUsers' => $response->data]
            );
        } catch (ClientException $th) {
            return back();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255', 'unique:sermons'],
            'content' => ['required', 'string'],
            'speaker_name' => ['required', 'string'],
            'speaker_position' => ['required', 'string']
        ]);

        $data = [
            [
                'name' => 'topic',
                'contents' => $request->input('topic')
            ],
            [
                'name' => 'content',
                'contents' => $request->input('content')
            ],
            [
                'name' => 'speaker_name',
                'contents' => $request->input('speaker_name')
            ],
            [
                'name' => 'speaker_position',
                'contents' => $request->input('speaker_position')
            ],
            [
                'name' => 'user_image',
                'contents' => $request->input('user_image')
            ],
            [
                'name' => 'video_url',
                'contents' => $request->input('video_url')
            ],
            [
                'name' => 'speaker_image',

                'contents' => $request->hasfile('speaker_image') ? fopen($request->file('speaker_image')->getPathname(), 'r') : null
            ],
            [
                'name' => 'coverImage',

                'contents' => $request->hasfile('coverImage') ? fopen($request->file('coverImage')->getPathname(), 'r') : null
            ]
        ];

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $res = $client->post('api/sermon?api_token=' . Auth::user()->api_token, ['multipart' =>  $data]);
            return  redirect()->route('dsermons');
        } catch (ClientException $th) {
            echo ($th);
            return back();
        }
    }

    public function show($id)
    {
        try {
            $endpoint = 'api/sermon_single/' . Crypt::decrypt($id);
            $client = new Client(['base_uri' => config('app.api_base')]);

            //check_auth and add token
            if (Auth::id() != null)
                $endpoint = 'api/sermon_single/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token;

            $response = json_decode($client->get($endpoint)->getBody());

            return view(
                'pages.sermon-single',
                ['data' => $response]
            );
        } catch (ClientException $th) {
            return back();
        }
    }


    public function edit($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/sermon/' . $id)->getBody());
            $speakers = json_decode($client->get('api/speakers')->getBody());

            return view(
                'pages.dashboard.create_edit_sermon',
                ['sermon' => $response->data, 'systemUsers' => $speakers->data]
            );
        } catch (ClientException $th) {
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'speaker_name' => ['required', 'string'],
            'speaker_position' => ['required', 'string']
        ]);

        $data = [
            [
                'name' => 'topic',
                'contents' => $request->input('topic')
            ],
            [
                'name' => 'content',
                'contents' => $request->input('content')
            ],
            [
                'name' => 'speaker_name',
                'contents' => $request->input('speaker_name')
            ],
            [
                'name' => 'speaker_position',
                'contents' => $request->input('speaker_position')
            ],
            [
                'name' => 'user_image',
                'contents' => $request->input('user_image')
            ],
            [
                'name' => 'video_url',
                'contents' => $request->input('video_url')
            ],
            [
                'name' => 'speaker_image',

                'contents' => $request->hasfile('speaker_image') ? fopen($request->file('speaker_image')->getPathname(), 'r') : null
            ],
            [
                'name' => 'coverImage',

                'contents' => $request->hasfile('coverImage') ? fopen($request->file('coverImage')->getPathname(), 'r') : null
            ]
        ];

        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->post('api/sermon/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token, [
                'multipart' => $data,
            ]);
            return redirect()->route('dsermons');
        } catch (ClientException $th) {
            return back();
        }
    }


    public function details($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/sermon/' . $id)->getBody());

            return view('pages.dashboard.sermon_details', ['sermon' => $response->data]);
        } catch (ClientException $th) {
            return back();
        }
    }



    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->delete('api/sermon/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token);
            return  redirect()->route('dsermons');
        } catch (ClientException $th) {
            return back();
        }
    }
}

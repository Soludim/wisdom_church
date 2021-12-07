<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class EventController extends Controller
{
    public function dindex($page = 1)
    {

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/event?page=' . $page)->getBody());

            return view('pages.dashboard.events', ['data' => $response->events]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function index($page = 1)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/event?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/event?page=' . Crypt::decrypt($page))->getBody());


            return view('pages.events', ['data' => $response]);
        } catch (ClientException $th) {
            return back();
        }
    }


    public function create()
    {
        return view('pages.dashboard.create_edit_event', ['event' => null]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:events'],
            'details' => ['required', 'string']
        ]);

        $data = [
            [
                'name' => 'name',
                'contents' => $request->input('name')
            ],
            [
                'name' => 'details',
                'contents' => $request->input('details')
            ],
            [
                'name' => 'venue',
                'contents' => $request->input('venue')
            ],
            [
                'name' => 'date',
                'contents' => $request->input('date')
            ],
            [
                'name' => 'time',
                'contents' => $request->input('time')
            ],
            [
                'name' => 'coverImage',
                'contents' => $request->hasfile('coverImage') ?
                    fopen($request->file('coverImage')->getPathname(), 'r') : null
            ]
        ];

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $client->post('api/event?api_token=' . Auth::user()->api_token, ['multipart' => $data]);
            return  redirect()->route('devents');
        } catch (ClientException $th) {
            return back();
        }
    }


    public function show($id)
    {
        try {
            $endpoint = 'api/event/' . Crypt::decrypt($id);
            $client = new Client(['base_uri' => config('app.api_base')]);

            //check_auth and add token
            // if (Auth::id() != null)
            //     $endpoint = 'api/event/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token;

            $response = json_decode($client->get($endpoint)->getBody());
            return view(
                'pages.event-single',
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

            $response = json_decode($client->get('api/event/' . $id)->getBody());

            return view('pages.dashboard.create_edit_event', ['event' => $response->event]);
        } catch (ClientException $th) {
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string']
        ]);

        $data = [
            [
                'name' => 'name',
                'contents' => $request->input('name')
            ],
            [
                'name' => 'details',
                'contents' => $request->input('details')
            ],
            [
                'name' => 'venue',
                'contents' => $request->input('venue')
            ],
            [
                'name' => 'date',
                'contents' => $request->input('date')
            ],
            [
                'name' => 'time',
                'contents' => $request->input('time')
            ],
            [
                'name' => 'coverImage',
                'contents' => $request->hasfile('coverImage') ?
                    fopen($request->file('coverImage')->getPathname(), 'r') : null
            ]
        ];

        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $res = $client->post('api/event/' . $id . '?api_token=' . Auth::user()->api_token, [
                'multipart' => $data,
            ]);

            return redirect()->route('devents');
        } catch (ClientException $th) {
            return back();
        }
    }

    public function details($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/event/' . $id)->getBody());

            return view('pages.dashboard.event_details', ['event' => $response->event]);
        } catch (ClientException $th) {
            return back();
        }
    }



    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->delete('api/event/' . $id . '?api_token=' . Auth::user()->api_token);
            return  redirect()->route('devents');
        } catch (ClientException $th) {
            return back();
        }
    }
}

<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class PrayerRequestController extends Controller
{
    public function index($page = 1, Request $request)
    {
        $status = 0;
        if ($request->input('status')) {
            $status = $request->input('status');
        }

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
              $response = json_decode($client->get('api/prayerrequest?page='.$page.'&status='.$status)->getBody());
            else
               $response = json_decode($client->get('api/prayerrequest?page='.Crypt::decrypt($page).'&status='.$status)->getBody());

            if($page != 1)dd(Crypt::decrypt($page));
            return view('pages.dashboard.prayer_request', ['data' => $response->data]);
        } catch (\Throwable $th) {
            return back();
        }
    }


    public function store(Request $request)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $res = json_decode($client->post('api/prayerrequest', ['form_params' =>  [
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


    public function show($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $response = json_decode($client->get('api/prayerrequest/' . $id)->getBody());
            return view('pages.dashboard.prayer_request', ['data' => $response]);
        } catch (ClientException $th) {
            echo ($th);
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->put('api/prayerrequest/' . $id . '?api_token=' . Auth::user()->api_token);
            return redirect()->route('prayerrequest');
        } catch (ClientException $th) {
            echo ('error');
            return back();
        }
    }

    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->delete('api/prayerrequest/' . $id . '?api_token=' . Auth::user()->api_token);
            return  redirect()->route('prayerrequest');
        } catch (ClientException $th) {
            echo ($th);
            return back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.profile');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lives_in' => ['required', 'string'],
            'contact' => ['required', 'string']
        ]);

        $client = new Client(['base_uri' => config('app.api_base')]);
        $data = [
            [
                'name' => 'name',
                'contents' => $request->input('name')
            ],
            [
                'name' => 'contact',
                'contents' => $request->input('contact')
            ],
            [
                'name' => 'lives_in',
                'contents' => $request->input('lives_in')
            ],
            [
                'name' => 'profile_pic',
                'contents' => $request->hasfile('profile_pic') ? fopen($request->file('profile_pic')->getPathname(), 'r') : null
            ]
        ];

        try {
            $response = json_decode($client->post('api/profile?api_token=' . Auth::user()->api_token, ['multipart' => $data])->getBody());
            $notification = array(
                'message' => $response->message,
                'alert_type' => $response->status
            );

            return redirect()->route('profile.index')->with('message', $notification);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' =>  ['required', 'string', 'min:8', 'confirmed']
        ]);
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $res = $client->put('api/passwordreset?api_token=' . Auth::user()->api_token, ['form_params' =>
            [
                'old_password' => $request->input('old_password'),
                'new_password' => $request->input('new_password'),
                'new_password_confirmation' => $request->input('new_password_confirmation'),
            ]]);

            $response = json_decode($res->getBody());

            $notification = array(
                'message' => $response->message,
                'alert_type' => $response->status
            );

            return redirect()->route('profile.index')->with('message', $notification);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function members($page = 1)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $members = json_decode($client->get('api/user?page=' . $page)->getBody());
            else
                $members = json_decode($client->get('api/user?page=' . Crypt::decrypt($page))->getBody());

            $roles = json_decode($client->get('api/role')->getBody());
            $res = ['roles' => $roles->data, 'members' => $members->data];

            return view('pages.dashboard.members', ['data' => $res]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function update_role(Request $request)
    { //change user role
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $client->post('api/user/role?api_token=' . Auth::user()->api_token, ['form_params' =>
            [
                'userId' => $request->input('userId'),
                'role' => $request->input('role'),
            ]]);

            return redirect()->route('members');
        } catch (ClientException $th) {
            return back();
        }
    }
}

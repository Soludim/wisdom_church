<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function myposts($page = 1)
    {

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/user/' . Auth::user()->id . '/post' . '?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/user/' . Auth::user()->id . '/post' . '?page=' . Crypt::decrypt($page))->getBody());

            return view('pages.dashboard.posts', ['data' => $response->data]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function allposts($page = 1)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/post?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/post?page=' . Crypt::decrypt($page))->getBody());

            return view('pages.dashboard.allposts', ['data' => $response->posts]);
        } catch (ClientException $th) {
            return back();
        }
    }

    public function index($page = 1)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            if ($page == 1)
                $response = json_decode($client->get('api/post?page=' . $page)->getBody());
            else
                $response = json_decode($client->get('api/post?page=' . Crypt::decrypt($page))->getBody());

            return view('pages.blog', ['data' => $response]);
        } catch (ClientException $th) {
            return back();
        }
    }


    public function create()
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $category = json_decode($client->get('api/category')->getBody());

            return view(
                'pages.dashboard.create_edit_post',
                ['data' => null, 'categories' => $category->data]
            );
        } catch (ClientException $th) {
            return back();
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts'],
            'content' => ['required', 'string'],
            'category' => ['required', 'integer'],
            'coverImage' => ['required']
        ]);
        $data = [
            [
                'name' => 'title',
                'contents' => $request->input('title')
            ],
            [
                'name' => 'content',
                'contents' => $request->input('content')
            ],
            [
                'name' => 'category_id',
                'contents' => $request->input('category')
            ],
            [
                'name' => 'coverImage',
                'Mime-Type' => $request->file('coverImage')->getMimeType(),
                'contents' => fopen($request->file('coverImage')->getPathname(), 'r')
            ]
        ];

        try {
            $client = new Client(['base_uri' => config('app.api_base')]);
            $client->post('api/post?api_token=' . Auth::user()->api_token, ['multipart' => $data]);
            return  redirect()->route('posts');
        } catch (ClientException $th) {
            return back();
        }
    }


    public function show($id)
    {
        try {
            $endpoint = 'api/blog_single/' . Crypt::decrypt($id);
            $client = new Client(['base_uri' => config('app.api_base')]);
            //check_auth and add token
            if (Auth::id() != null)
                $endpoint = 'api/blog_single/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token;
            $response = json_decode($client->get($endpoint)->getBody());
            return view(
                'pages.blog-single',
                ['data' => $response->data]
            );
        } catch (ClientException $th) {
            return back();
        }
    }

    public function details($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $response = json_decode($client->get('api/post/'.$id)->getBody());

            return view('pages.dashboard.post_details', ['post' => $response->data]);
        } catch (ClientException $th) {
            return back();
        }
    }


    public function edit($id)
    {
        try {
            $client = new Client(['base_uri' => config('app.api_base')]);

            $categories = json_decode($client->get('api/category/')->getBody());
            $response = json_decode($client->get('api/post/'.$id)->getBody());

            return view(
                'pages.dashboard.create_edit_post',
                ['data' => $response->data, 'categories' => $categories->data]
            );
        } catch (ClientException $th) {
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'integer']
        ]);

        $data = [
            [
                'name' => 'title',
                'contents' => $request->input('title')
            ],
            [
                'name' => 'content',
                'contents' => $request->input('content')
            ],
            [
                'name' => 'category_id',
                'contents' => $request->input('category')
            ],
            [
                'name' => 'coverImage',
                'contents' => $request->hasfile('coverImage')
                    ? fopen($request->file('coverImage')->getPathname(), 'r') : null
            ]
        ];

        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->post('api/post/' . Crypt::decrypt($id) . '?api_token=' . Auth::user()->api_token, [
                'multipart' => $data,
            ]);

            return redirect('/post/' . $id . '/details');
        } catch (ClientException $th) {
            return back();
        }
    }


    public function destroy($id)
    {
        $client = new Client(['base_uri' => config('app.api_base')]);
        try {
            $client->delete('api/post/' . $id . '?api_token=' . Auth::user()->api_token);
            return  redirect()->route('posts');
        } catch (ClientException $th) {
            return back();
        }
    }
}

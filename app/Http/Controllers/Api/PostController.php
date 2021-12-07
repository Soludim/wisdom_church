<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use App\Comment;
use App\Event;
use App\PostCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'destroy']);
    }

    // Display a listing of the post.
    public function index(Request $request)
    {
        $posts = Post::where('title', 'LIKE', '%'.$request->input('title').'%')->latest()->with(['category', 'user'])->withCount('comments')->paginate(10);
        $earliestEvent = Event::all()->sortBy(function($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();
        return response()->json(["posts" => $posts, "earliestEvent" => $earliestEvent]);
    }

    public function user_posts($id, Request $request)
    {
        $posts = Post::where('user_id', $id)->where('title', 'LIKE', '%'.$request->input('title').'%')->latest()->with(['category'])->paginate(10);
        return response()->json(["data" => $posts]);
    }


    // Store a newly created post in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'unique:posts'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer'],
            'coverImage' => ['required']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $post = new Post();
        $post->title = strtoupper($request->input('title'));
        $post->content = $request->input('content');
        $post->user_id = $request->user()->id;
        $post->category_id = $request->input('category_id');

        if ($post->save()) {
            if ($request->hasfile('coverImage')) {
                $ext = $request->file('coverImage')->extension();
                $coverImage_path = $request->file('coverImage')->storeAs('posts', $post->id . '.' . $ext, 'public');
                $post->coverImage = $coverImage_path;
                $post->save();
            }
            return response()->json(["data" => $post, "message" => "Post created successfully"]);
        }
    }

    //get all categories
    public function categories()
    {
        $categories = PostCategory::all();
        $subset = $categories->map(function ($category) {
            return $category->only(['id', 'name']);
        });
        return response()->json(["data" => $subset]);
    }

    // Display the specified post.
    public function show($id)
    {
        $post = Post::with(['category', 'user'])->withCount('comments')->find($id);
        if ($post == null) {
            return response()->json(["message" => "Post does not exist"]);
        }
        return response()->json(["data" => $post]);
    }

    public function blog_single($id)
    {
        $post = Post::with(['category', 'user','comments.user', 'comments.replies.user'])->find($id);
        $earliestEvent = Event::all()->sortBy(function($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();        ///get the ealiest event and send it to the page
        if ($post == null) {
            return response()->json(["message" => "Post does not exist"]);
        }
        $latest_posts = Post::latest()->where('id', '!=', $id)->with(['user'])->withCount('comments')->limit(3)->get();
        $category_posts = PostCategory::withCount('posts')->get();
        // $comments = Comment::where('commentable_type', 'App\Post')
        //     ->where('commentable_id', $id)->withCount('replies')->with(['user', 'replies.user'])->get();
        $all = [
            'post' => $post,
            'latest_posts' => $latest_posts,
            'category_posts' => $category_posts,
            'earliestEvent' => $earliestEvent
        ];
        return response()->json(['data' => $all]);
    }


    //  Update the specified post in storage. //a post method
    public function update_post(Request $request, $id)
    {
        $post = Post::find($id);
        if ($post == null)
            return response()->json("post does not exist");

        $val = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        if ($request->user()->id != $post->user_id) {
            return response()->json(["message" => "Unauthaurized to edit this post"]);
        }

        $post->title = strtoupper($request->input('title'));
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');

        if ($request->hasfile('coverImage')) {

            if (Storage::exists('public/' . $post->coverImage)) {
                Storage::delete('public/' . $post->coverImage);
            }

            $ext = $request->file('coverImage')->extension();
            $coverImage_path = $request->file('coverImage')->storeAs('posts', $post->id . '.' . $ext, 'public');
            $post->coverImage = $coverImage_path;
        }

        $post->save();
        return response()->json(["data" => $post, "message" => "Update was successful"]);
    }


    // Remove the specified post from storage.
    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post == null) {
            return response()->json(["message" => "Post does not exist"]);
        }

        if ($request->user()->role_id != 1 && $request->user()->id != $post->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this post"]);
        }

        // $post->likes()->delete();
        foreach ($post->comments as $comment) {
            foreach ($comment->replies as $reply)
                $reply->likes()->delete();
        }
        foreach ($post->comments as $comment) {
            $comment->replies()->delete(); // delete all replies relating to the comments of this post
        }
        foreach ($post->comments as $comment) {
            $comment->likes()->delete(); // delete all likes relating to the comments of this post
        }

        $post->comments()->delete();   //delete all comments relating to this post

        if (Storage::exists('public/' . $post->coverImage)) {
            Storage::delete('public/' . $post->coverImage);
        }

        $post->delete();
        return response()->json(["data" => $post, "message" => "Post deleted successfully"]);
    }

    public function category_posts()
    {
        $category_posts = PostCategory::withCount('posts')->get();
        return response()->json(['data' => $category_posts]);
    }
}

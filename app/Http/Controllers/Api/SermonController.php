<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Sermon;
use App\Event;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SermonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['store', 'destroy']);
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $sermons = Sermon::where('topic', 'LIKE', '%'.$request->input('topic').'%')->latest()->paginate(10);
        $earliestEvent = Event::all()->sortBy(function ($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();
        return response()->json(["sermons" => $sermons, "earliestEvent" => $earliestEvent]);
    }


    // Store a newly created sermon in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'topic' => ['required', 'string', 'max:255', 'unique:sermons'],
            'content' => ['required', 'string'],
            'speaker_name' => ['required', 'string'],
            'speaker_position' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }


        $sermon = new Sermon();
        $sermon->topic = strtoupper($request->input('topic'));
        $sermon->content = $request->input('content');
        $sermon->speaker_name = $request->input('speaker_name');
        $sermon->speaker_position = $request->input('speaker_position');
        $sermon->video_url = $request->input('video_url');
        $sermon->coverImage = 'sermons/default.jpg';
        $sermon->speaker_image = 'profile_pics/default.png';


        if ($sermon->save()) {
            if ($request->hasfile('coverImage')) {
                $ext = $request->file('coverImage')->extension();
                $coverImage_path = $request->file('coverImage')->storeAs('sermons', $sermon->id . '.' . $ext, 'public');
                $sermon->coverImage = $coverImage_path;
            }
            if ($request->hasfile('speaker_image')) {
                //when speaker image is uploaded
                $ext = $request->file('speaker_image')->extension();
                $speakerImagePath = $request->file('speaker_image')->storeAs('sermons', $sermon->id . '-speaker' . '.' . $ext, 'public');
                $sermon->speaker_image = $speakerImagePath;
            } else if ($request->input('user_image')) {
                $sermon->speaker_image = $request->input('user_image'); //when speaker is already in the system
            }
            // if ($request->hasfile('video_url')) {
            //     $ext = $request->file('video_url')->extension();
            //     $sermon_vid_path = $request->file('video_url')->storeAs('sermons', $sermon->id . '.' . $ext, 'public');
            //     $sermon->video_url = $sermon_vid_path;
            // }
            $sermon->save();
            return response()->json(["data" => $sermon, "message" => "Sermon creation was successful"]);
        }
    }

    public function sermon_single($id)
    {
        $sermon = Sermon::with([
            'comments.user', 'comments.replies.user'
        ])->find($id);
        if ($sermon == null) {
            return response()->json(["message" => "Sermon does not exist"]);
        }
        $earliestEvent = Event::all()->sortBy(function ($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();        ///get the earliest event and send it to the page

        return response()->json(['sermon' => $sermon, 'earliestEvent' => $earliestEvent]);
    }


    // Display the specified sermon.
    public function show($id)
    {
        $sermon = Sermon::find($id);
        if ($sermon == null) {
            return response()->json(["message" => "sermon does not exist"]);
        }
        return response()->json(["data" => $sermon]);
    }

    // Update the specified resource in storage. //a post method
    public function update_sermon(Request $request, $id)
    {

        $sermon = Sermon::find($id);
        if ($sermon == null)
            return response()->json(["message" => "sermon does not exist"]);


        $val = Validator::make($request->all(), [
            'topic' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'speaker_name' => ['required', 'string'],
            'speaker_position' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $sermon->topic = strtoupper($request->input('topic'));
        $sermon->content = $request->input('content');
        $sermon->speaker_name = $request->input('speaker_name');
        $sermon->speaker_position = $request->input('speaker_position');

        if ($request->hasfile('coverImage')) {

            if (
                Storage::exists('public/' . $sermon->coverImage)
                && $sermon->coverImage != 'sermons/default.jpg'
            ) {
                Storage::delete('public/' . $sermon->coverImage);
            }

            $ext = $request->file('coverImage')->extension();
            $coverImage_path = $request->file('coverImage')->storeAs('sermons', $sermon->id . '.' . $ext, 'public');
            $sermon->coverImage = $coverImage_path;
        }

        $extension = substr($sermon->speaker_image, strrpos($sermon->speaker_image, '.') + 1);
        if ($request->hasfile('speaker_image')) {
            //delete old sermon speaker image only if it is not the default image
            if (
                Storage::exists('public/' . $sermon->speaker_image)
                && $sermon->speaker_image != 'profile_pics/default.png'
                && $sermon->speaker_image == 'sermons/' . $sermon->id . '-speaker.' . $extension
            ) {
                Storage::delete('public/' . $sermon->speaker_image);
            }
            //save new speaker image into file system and update database
            $ext = $request->file('speaker_image')->extension();
            $speakerImagePath = $request->file('speaker_image')->storeAs('sermons', $sermon->id . '-speaker' . '.' . $ext, 'public');
            $sermon->speaker_image = $speakerImagePath;
        } else if ($request->input('user_image')) {
            //delete old sermon speaker image only if it is not the default image
            if (
                Storage::exists('public/' . $sermon->speaker_image)
                && $sermon->speaker_image != 'profile_pics/default.png'
                && $sermon->speaker_image == 'sermons/' . $sermon->id . '-speaker.' . $extension
            ) {
                Storage::delete('public/' . $sermon->speaker_image);
            }

            $sermon->speaker_image = $request->input('user_image');
        }


        // if ($request->hasfile('video_url')) {

        //     if (Storage::exists('public/' . $sermon->video_url)) {
        //         Storage::delete('public/' . $sermon->video_url);
        //     }

        //     $ext = $request->file('video_url')->extension();
        //     $video_url_path = $request->file('video_url')->storeAs('sermons', $sermon->id . '.' . $ext, 'public');
        //     $sermon->video_url = $video_url_path;
        // }

        $sermon->save();
        return response()->json(["data" => $sermon, "message" => "Sermon updated successfully"]);
    }


    // Remove the specified sermon from storage.
    public function destroy(Request $request, $id)
    {
        $sermon = Sermon::find($id);
        if ($sermon == null) {
            return response()->json(["message" => "sermon does not exist"]);
        }

        if ($request->user()->role_id != 1 &&  $request->user()->id != $sermon->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this sermon"]);
        }

        foreach ($sermon->comments as $comment) {
            foreach ($comment->replies as $reply)
                $reply->likes()->delete();
        }
        foreach ($sermon->comments as $comment) {
            $comment->replies()->delete(); // delete all replies relating to the comments of this sermon
        }
        foreach ($sermon->comments as $comment) {
            $comment->likes()->delete(); // delete all likes relating to the comments of this sermon
        }

        $sermon->comments()->delete();   //delete all comments relating to this sermon


        // if (Storage::exists('public/' . $sermon->video_url)) {
        //     Storage::delete('public/' . $sermon->video_url);
        // }

        if (
            Storage::exists('public/' . $sermon->coverImage)
            && $sermon->coverImage != 'sermons/default.jpg'
        ) {
            Storage::delete('public/' . $sermon->coverImage);
        }

        if (
            Storage::exists('public/' . $sermon->speaker_image)
            && $sermon->speaker_image != 'profile_pics/default.png'
        ) {
            Storage::delete('public/' . $sermon->speaker_image);
        }

        $sermon->delete();
        return response()->json(["data" => $sermon]);
    }

    //potential speakers who are users in the system
    public function speakerQueryResult()
    {
        //$queryName = $request->input('name');
        $users = User::with('role')->get();

        // $userQueryResults = $users->filter(function ($user) use ($queryName) {
        //     if (Str::contains(strtoupper($user->name), strtoupper($queryName)))
        //         return $user;
        // });

        return response()->json(["data" => $users]);
    }
}

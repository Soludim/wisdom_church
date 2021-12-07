<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Event;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', CheckRole::class])->only(['store', 'destroy']);
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $events = Event::where('name', 'LIKE', '%'.$request->input('name').'%')->latest()->paginate(10);
        $earliestEvent = Event::all()->sortBy(function ($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();           //get the earliest event
        return response()->json(["events" => $events, "earliestEvent" => $earliestEvent]);
    }

    // Store a newly created event in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:events'],
            'details' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }


        $event = new Event();
        $event->name = strtoupper($request->input('name'));
        $event->details = $request->input('details');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->venue = $request->input('venue');
        $event->coverImage = 'events/default.jpg';


        if ($event->save()) {
            if ($request->hasfile('coverImage')) {
                $ext = $request->file('coverImage')->extension();
                $coverImage_path = $request->file('coverImage')->storeAs('events', $event->id . '.' . $ext, 'public');
                $event->coverImage = $coverImage_path;
                $event->save();
            }
            return response()->json(["data" => $event, "message" => "Event creation was successful"]);
        }
    }


    // Display the specified event.
    public function show($id)
    {
        $event = Event::find($id);
        $earliestEvent = Event::all()->sortBy(function ($event) {
            if (!$event->date || !$event->time)
                return '40000-01-01-00:00:00';
            return $event->date . '-' . $event->time;
        })->where('standing', true)->first();        //get the latest event and send it

        if ($event == null) {
            return response()->json(["message" => "Event does not exist"]);
        }
        return response()->json(["event" => $event, "earliestEvent" => $earliestEvent]);
    }

    // Update the event resource in storage. //a post request
    public function update_event(Request $request, $id)
    {

        $event = Event::find($id);
        if ($event == null)
            return response()->json(["message" => "Event does not exist"]);

        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $event->name = strtoupper($request->input('name'));
        $event->details = $request->input('details');
        $event->date = $request->input('date');
        $event->time = $request->input('time');
        $event->venue = $request->input('venue');

        if ($request->hasfile('coverImage')) {

            if (Storage::exists('public/' . $event->coverImage) && $event->coverImage != 'events/default.jpg') {
                Storage::delete('public/' . $event->coverImage);
            }

            $ext = $request->file('coverImage')->extension();
            $coverImage_path = $request->file('coverImage')->storeAs('events', $event->id . '.' . $ext, 'public');
            $event->coverImage = $coverImage_path;
        }

        $event->save();
        return response()->json(["data" => $event, "message" => "Event updated successfully"]);
    }


    // Remove the specified event from storage.
    public function destroy(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event == null) {
            return response()->json(["message" => "Event does not exist"]);
        }

        if ($request->user()->role_id != 1) {
            return response()->json(["message" => "Unauthaurized to delete this event"]);
        }

        if (Storage::exists('public/' . $event->coverImage)) {
            Storage::delete('public/' . $event->coverImage);
        }

        $event->delete();
        return response()->json(["data" => $event]);
    }
}

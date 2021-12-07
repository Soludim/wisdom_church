<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libraries\TodayData;

class TestimonyController extends Controller
{

    public function __construct() {

        $this->middleware('auth:api', ['only' => ['store', 'destroy']]);

    }

    //Display a listing of the resource.
    public function index()
    {
        $testimonies = Testimony::with('user')->paginate(7);
        return response()->json(["data" => $testimonies]);
    }


    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'content' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["message" => $val->errors(), "status"=>"error"]);
        }


        $testimony = new Testimony();
        $testimony->content = $request->input('content');
        $testimony->user_id = $request->user()->id;

        if ($testimony->save()) {
            TodayData::statistics([
                'prayer_requests' => 0,
                'testimonies' => 1,
                'mail_received' => 0,
                'users' => 0
            ]);                        ///updates today's statistics
            return response()->json(["data" => $testimony, "message" => "Testimony added successfully", "status"=>"success"]);
        }
    }


    // Display the specified resource.
    public function show($id)
    {
        $testimony = Testimony::find($id);
        if ($testimony == null) {
            return response()->json(["message" => "Testimony does not exist"]);
        }
        return response()->json(["data" => $testimony]);
    }

    //Remove the specified resource from storage.
    public function destroy(Request $request, $id)
    {
        $testimony = Testimony::find($id);
        if ($testimony == null) {
            return response()->json(["message" => "Testimony does not exist"]);
        }

        if ($request->user()->role_id != 1 && $request->user()->id != $testimony->user_id) {
            return response()->json(["message" => "Unauthaurized to delete this testimony"]);
        }


        $testimony->delete();
        return response()->json(["data" => $testimony, "message" => "Testimony removed successfully"]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PrayerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Libraries\TodayData;

class PrayerRequestController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:api', ['only' => ['update', 'destroy']]);
    }

    // Display a listing of the resource.
    public function index(Request $request)
    {
        $pRs = '';

         if ($request->input('status') == 1) {
             //request prayed
             $pRs = PrayerRequest::where('status', 'prayed')->paginate(7);
         } else if ($request->input('status') == 2) {
             //standing prayer requests
             $pRs = PrayerRequest::where('status', 'standing')->paginate(7);
         } else {
             //all prayer requests including the ones prayed and the ones standing
             $pRs = PrayerRequest::paginate(7);
         }
 
         return response()->json(["data" => $pRs]);
    }

     // Display the specified resource.
     public function show($id)
     {
         $pR = PrayerRequest::find($id);
         if ($pR == null) {
             return response()->json(["message" => "Prayer request does not exist"]);
         }
         return response()->json(["data" => $pR]);
     }


    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'content' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["message" => $val->errors(), "status"=>"error"]);
        }

        $pR = new PrayerRequest();
        $pR->content = $request->input('content');

        if ($pR->save()) {
            TodayData::statistics([
                'prayer_requests' => 1,
                'testimonies' => 0,
                'mail_received' => 0,
                'users' => 0
            ]);                        ///updates today's statistics
            return response()->json(["data" => $pR, "message" => "Prayer Request sent successfully", "status"=>"success"]);
        }
    }

    // Update status of specified prayer request in storage
    public function update(Request $request, $id)
    {
        $pR = PrayerRequest::find($id);
        if ($pR == null)
            return response()->json(["message" => "item does not exist"]);


        if ($pR->status == 'standing') {
            $pR->status = 'prayed';
        } else {
            $pR->status = 'standing';
        }

        $pR->save();
        return response()->json(["data" => $pR, "message" => "Status changed successful"]);
    }


    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $pR = PrayerRequest::find($id);
        if ($pR == null) {
            return response()->json(["message" => "Prayer request does not exist"]);
        }
        if ($pR->delete()) {
            return response()->json(["data" => $pR, "message" => "Prayer request removed successfully"]);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use App\Libraries\TodayData;

class ContactController extends Controller
{
    public function sendMail(Request $request)
    {
        $val = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        if ($val->fails()) {
            return response()->json(["message" => $val->errors(), "status"=>"error"]);
        }

        $data = array(
            'name' => $request->input('name'), 'body' => $request->input('message'),
            'subject' => $request->input('subject'), 'from' => $request->input('email')
        );
        \Mail::to('israeldebrah45@gmail.com')->send(new SendMail($data));
        TodayData::statistics([
            'prayer_requests' => 0,
            'testimonies' => 0,
            'mail_received' => 1,
            'users' => 0
        ]);                        ///updates today's statistics
        return response()->json(["message" => "Mail sent", "status"=>"error"]);
    }
}

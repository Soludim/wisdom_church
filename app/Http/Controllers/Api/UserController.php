<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\ChatUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Libraries\TodayData;

class UserController extends Controller
{

    //Display a listing of all Users.
    public function index(Request $request)
    {
        $members = '';
        // return response()->json($request->input('username'));
        if ($request->input('role') == 1) {
            //leaders
            $members = User::with('role')
                ->where('name', 'LIKE', '%' . $request->input('username') . '%')
                ->where('role_id', '!=', 2)->paginate(16);
        } else if ($request->input('role') == 2) {
            //members
            $members = User::with('role')
                ->where('name', 'LIKE', '%' . $request->input('username') . '%')
                ->where('role_id', 2)->paginate(16);
        } else {
            //all users
            $members = User::with('role')
                ->where('name', 'LIKE', '%' . $request->input('username') . '%')
                ->paginate(16);
        }

        return response()->json(["data" => $members]);
    }

    public function show($id)
    {
        $user = User::find($id)
            ->only(['id', 'email', 'password', 'contact', 'lives_in', 'initials', 'profile_pic']);
        if ($user == null) {
            return response()->json(["message" => "User does not exist"]);
        }
        return response()->json($user);
    }

    public function login(Request $request)
    {
        $val = Validator::make($request->all(), [
            'email' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);


        if ($val->fails()) {
            return response()->json($val->errors());
        }

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            $success = Hash::check($request->input('password'), $user->password);

            if ($success)
                return response()->json($user);
        }
        return response()->json(['message' => 'Invalid credentials'], 404);
    }


    public function register(Request $request)
    {
        $initials = '';
        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lives_in' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($val->fails()) {
            return response()->json(["error" => $val->errors()]);
        }

        $words = preg_split("/\s+/", $request->input('name'));
        foreach ($words as $w)
            $initials .= $w[0] . '.';

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'initials' => $initials,
            'lives_in' => $request->input('lives_in'),
            'contact' => $request->input('contact'),
            'api_token' => Str::random(60),
            'profile_pic' => 'profile_pics/default.png',
            'password' => Hash::make($request->input('password')),
        ]);

        if ($request->hasfile('profile_pic')) {
            $ext = $request->file('profile_pic')->extension();
            $profile_pic_path = $request->file('profile_pic')->storeAs('profile_pics', $user->id . '.' . $ext, 'public');
            $user->profile_pic = $profile_pic_path;
            $user->save();
        }

        ChatUser::create([
            "user_id" => $user->id,
            "chat_id" => 1
        ]);                                // User automatically added to Members Chat Room

        TodayData::statistics([
            'prayer_requests' => 0,
            'testimonies' => 0,
            'mail_received' => 0,
            'users' => 1
        ]);                        ///updates today's statistics

        return $user;
    }


    //Update the user in storage.
    public function update(Request $request)
    {
        $user = $request->user();

        if ($user == null) {
            return response()->json(["message" => "Unauthenticated"]);
        }

        $val = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'lives_in' => ['required', 'string'],
            'contact' => ['required', 'string']
        ]);


        if ($val->fails()) {
            return response()->json(["message" => $val->errors(), "status" => "error"]);
        }


        $user->name = $request->input('name');
        $user->lives_in = $request->input('lives_in');
        $user->contact = $request->input('contact');
        if ($request->hasfile('profile_pic')) {

            if (
                Storage::exists('public/' . $user->profile_pic)
                && $user->profile_pic != 'profile_pics/default.png'
            ) {
                Storage::delete('public/' . $user->profile_pic);
            }

            $ext = $request->file('profile_pic')->extension();
            $profile_pic_path = $request->file('profile_pic')->storeAs('profile_pics', $user->id . '.' . $ext, 'public');
            $user->profile_pic = $profile_pic_path;
        }

        $user->save();

        return response()->json(["data" => $user, "message" => "User info updated successfully", "status" => "success"]);
    }

    public function changePassword(Request $request)
    {
        $val = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' =>  ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($val->fails()) {
            return response()->json($val->errors());
        }

        $user = $request->user();
        $rep = Hash::check($request->input('old_password'), $request->user()->password);

        if ($rep) {
            // old password matches
            $user->password = Hash::make($request->input('new_password'));
            $user->update();

            return response()->json(["message" => "Password reset successful", "status" => "success"]);
        } else {
            return response()->json(["message" => "Old password is invalid", "status" => "error"]);
        }
    }

    public function update_role(Request $request)
    {
        //update user role
        $val = Validator::make($request->all(), [
            'userId' => ['required', 'integer'],
            'role' =>  ['required', 'integer']
        ]);

        if ($val->fails()) {
            return response()->json($val->errors());
        }

        $user = User::find($request->input('userId'));
        if (!$user)
            return response()->json(["message" => "User not found"], 404);

        $user->role_id = $request->input('role');
        $user->save();

        return response()->json(["message" => "Role Changed"], 404);
    }

    public function destroy($id)
    {
        //
    }
}

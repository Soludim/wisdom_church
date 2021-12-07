<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\ChatUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Libraries\TodayData;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'lives_in' => ['string'],
            'contact' => ['string'],
            'password' => ['string', 'min:8'],
        ]);
    }


    protected function create(array $data)
    {
        $initials = '';
        $request = app('request');
        
        $words = preg_split("/\s+/", $request->input('name'));
        foreach($words as $w)
         $initials .= $w[0] . '.';

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'initials' => $initials,
            'lives_in' => $data['lives_in'],
            'contact' => $data['contact'],
            'api_token' => Str::random(60),
            'profile_pic' => 'profile_pics/default.png',
            'password' => Hash::make($data['password']),
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
}

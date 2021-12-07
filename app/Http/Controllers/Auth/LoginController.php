<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use App\Libraries\TodayData;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\ChatUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreate($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    public function findOrCreate($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        $initials = '';
        $words = preg_split("/\s+/", $user->name);
        foreach ($words as $w) {
            $initials .= $w[0] . '.';
        }

        $newUser = User::create([
            'name' =>  $user->name,
            'email' =>  $user->email,
            'initials' => $initials,
            'api_token' => Str::random(60),
            'provider' => $provider,
            'provider_id' => $user->id,
            'profile_pic' => $user->getAvatar()
        ]);

        ChatUser::create([
            "user_id" => $newUser->id,
            "chat_id" => 1
        ]);                                // User automatically added to Members Chat Room

        TodayData::statistics([
            'prayer_requests' => 0,
            'testimonies' => 0,
            'mail_received' => 0,
            'users' => 1
        ]);                        ///updates today's statistics

        return $newUser;
    }
}

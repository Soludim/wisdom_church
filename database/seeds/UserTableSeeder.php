<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
      User::create([
        "name" => "Israel Manu Debrah",
        "email"=> "israeldebrah45@gmail.com",
        'initials'=> 'I.M.D.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Maakro",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 1 
      ]);

      User::create([
        "name" => "Michael Narh",
        "email"=> "narh@gmail.com",
        'initials'=> 'M.N.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Kasoa",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 3 
      ]);

      User::create([
        "name" => "John Evans",
        "email"=> "evans@gmail.com",
        'initials'=> 'J.E.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Patasi",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 4 
      ]);

      User::create([
        "name" => "Kuukua Hazard",
        "email"=> "hazard@gmail.com",
        'initials'=> 'K.H.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Bremang",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 2 
      ]);

      User::create([
        "name" => "Nicholas Gyau",
        "email"=> "gyau@gmail.com",
        'initials'=> 'N.G.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Ahafo",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 4 
      ]);

      User::create([
        "name" => "Miraim Sarpong",
        "email"=> "miriam@gmail.com",
        'initials'=> 'M.S.',
        "password"=> Hash::make('incorrect'),
        "lives_in" => "Maakro",
        "contact" => "0558 3131 54",
        'api_token' => Str::random(60),
        "profile_pic"=>"profile_pics/default.png",
        "role_id" => 6 
      ]);
        
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Chat;

class ChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chat::create([
            "name" => "Members",
            "user_id" => 1,
            "info" => "Includes all members together with even the leaders.
            All infos to be known by the church is discussed here. It's a fun chat room"
        ]);
    }
}

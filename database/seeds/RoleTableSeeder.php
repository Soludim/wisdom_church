<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            "name"=>"Admin"
        ]);
        Role::create([
            "name"=>"Member"
        ]);
        Role::create([
            "name"=>"Presiding Elder"
        ]);
        Role::create([
            "name"=>"Elder"
        ]);
        Role::create([
            "name"=>"Deacon"
        ]);
        Role::create([
            "name"=>"Deaconess"
        ]);
        Role::create([
            "name"=>"Secretary"
        ]);
       
    }
}

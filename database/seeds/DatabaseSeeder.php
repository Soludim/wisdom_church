<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleTableSeeder::class,
            PostCategoryTableSeeder::class,
            UserTableSeeder::class,
            ChatTableSeeder::class,
            ChatUserTableSeeder::class,
            PostTableSeeder::class
        ]);
    }
}

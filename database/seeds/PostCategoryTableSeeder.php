<?php

use Illuminate\Database\Seeder;
use App\PostCategory;

class PostCategoryTableSeeder extends Seeder
{
    public function run()
    {
       
        PostCategory::create([
            "name"=>"Gospel"
        ]);
        PostCategory::create([
            "name"=>"Science & Technology"
        ]);
        PostCategory::create([
            "name"=>"Entertainment"
        ]);
        PostCategory::create([
            "name"=>"Sports"
        ]);
        PostCategory::create([
            "name"=>"Other"
        ]);
    }
}

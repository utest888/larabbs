<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();

        $category_ids = Category::all()->pluck('id')->toArray();


        $topics = Topic::factory(Topic::class)->times(50)->make()->each(function ($topic, $index) use ($user_ids, $category_ids) {

            $topic->user_id = $user_ids[array_rand($user_ids)];
            $topic->category_id = $category_ids[array_rand($category_ids)];
        });

        Topic::insert($topics->toArray());
    }
}

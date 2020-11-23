<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;

class RepliesTableSeeder extends Seeder
{
    public function run()
    {
        $users_ids = User::all()->pluck('id')->toArray();

        $topic_ids = Topic::all()->pluck('id')->toArray();


        $replies = Reply::factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use ($users_ids, $topic_ids) {
            $reply->user_id = $this->randElement($users_ids);
            $reply->topic_id = $this->randElement($topic_ids);
        });

        Reply::insert($replies->toArray());
    }

    private function randElement($arr)
    {
        if (empty($arr)) {
            return false;
        }

        $rand = mt_rand(0, count($arr) - 1);
        return $arr[$rand];
    }
}

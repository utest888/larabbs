<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function deleted(Topic $topic)
    {
        //
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }

    public function saving(Topic $topic)
    {
        //css过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        //生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        //如slug字段无内容，使用翻译器对title进行翻译
        if (empty($topic->slug)) {
            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            //推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function updating(Topic $topic)
    {
        //
    }
}

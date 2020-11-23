<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        //css过滤
        $topic->body = clean($topic->body, 'user_topic_body');

        //生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);

        //如slug字段无内容，使用翻译器对title进行翻译
        if (empty($topic->slug)) {
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }

    public function updating(Topic $topic)
    {
        //
    }
}

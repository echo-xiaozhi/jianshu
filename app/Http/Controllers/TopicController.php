<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //
    public function show(Topic $topic)
    {
        // 获取文章专题文章数
        $topic = Topic::withCount('postTopics')->find($topic->id);
        // 获取专题文章前10条
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();
        // 属于我的文章但是为投稿
        $myposts = \App\Post::authorBy(\Auth::id())->topicBy($topic->id)->get();
        // 渲染
        return view('topic.show', compact('topic', 'posts', 'myposts'));
    }

    public function submit(Topic $topic)
    {
        $this->validate(request(), [
            'post_ids' => 'required|array',
        ]);

        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id) {
            \App\PostTopic::firstOrCreate(compact('post_id', 'topic_id'));
        }
        return back();
    }
}

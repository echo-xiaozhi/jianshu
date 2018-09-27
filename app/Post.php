<?php

namespace App;

use App\Model;
use App\Zan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

/*
 *  Post 对应的就是 posts表
 *  如果要指定对应的表需要定义一个常量
 *  protected $table = 'posts2';
 */
class Post extends Model
{
//    use Searchable;
    //可以注入的字段
//    protected $fillable = ['title', 'content'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // 评论多对一
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    // 赞对文章
    public function zan($user_id)
    {
        return $this->hasOne(\App\Zan::class)->where('user_id', $user_id);
    }

    // 获取赞总数
    public function zans()
    {
        return $this->hasMany(\App\Zan::class);
    }

    // 获取属于某个作者的文章
    public function scopeAuthorBy(Builder $query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    //专题对应文章
    public function postTopics()
    {
        return $this->hasMany(\App\PostTopic::class, 'post_id', 'id');
    }

    // 不属于某个专题的文章
    public function scopeTopicBy(Builder $query, $topic_id)
    {
        // use 把外部变量传到匿名函数里面
        return $query->doesntHave('postTopics', 'and', function ($q) use ($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }
}


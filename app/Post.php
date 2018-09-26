<?php

namespace App;

use App\Model;
use App\Zan;

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

    // 得到该模型索引的名字
    /*public function searchableAs()
    {
        return 'post';
    }

    // 有哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }*/
}


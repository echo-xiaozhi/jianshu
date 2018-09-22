<?php

namespace App;

use App\Model;

/*
 *  Post 对应的就是 posts表
 *  如果要指定对应的表需要定义一个常量
 *  protected $table = 'posts2';
 */
class Post extends Model
{
    //可以注入的字段
//    protected $fillable = ['title', 'content'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

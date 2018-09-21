<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

/*
 *  Post 对应的就是 posts表
 *  如果要指定对应的表需要定义一个常量
 *  protected $table = 'posts2';
 */
class Model extends BaseModel
{
    //不可以注入的字段
    protected $guarded = [];
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // 列表页面
    public function index()
    {
        $posts = [
            ['title' => 'This is title1'],
            ['title' => 'This is title2'],
            ['title' => 'This is title3'],
        ];
        // compact 变量传递到模板 或者直接在view方法里面第二个参数 写个数组 eg:view('post/index', ['posts' => $posts])
        return view('post/index', compact('posts'));
    }

    // 详情页
    public function show()
    {

        return view('post/show', ['title' => 'This is title', 'isShow' => false]);
    }

    //创建文章
    public function create()
    {
        return view('post/create');
    }

    // 创建逻辑
    public function store()
    {

    }

    // 编辑文章
    public function edit()
    {
        return view('post/edit');
    }

    // 编辑逻辑
    public function update()
    {

    }

    // 删除
    public function delete()
    {

    }
}

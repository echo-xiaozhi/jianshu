<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 列表页面
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        // compact 变量传递到模板 或者直接在view方法里面第二个参数 写个数组 eg:view('post/index', ['posts' => $posts])
        return view('post/index', compact('posts'));
    }

    // 详情页
    public function show(Post $post)
    {
        return view('post/show', compact('post'));
    }

    //创建文章
    public function create()
    {
        return view('post/create');
    }

    // 创建逻辑
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|string|max:25|min:5',
            'content' => 'required|string|min:10',
        ]);

        Post::create(request(['title', 'content']));

        return redirect('/posts');
    }

    // 编辑文章
    public function edit(Post $post)
    {
        return view('post/edit', compact('post'));
    }

    // 编辑逻辑
    public function update(Post $post)
    {
        //验证
        $this->validate(request(), [
            'title' => 'required|string|max:25|min:5',
            'content' => 'required|string|min:10',
        ]);
        //逻辑
        $post->title = request('title');
        $post->content = \request('content');

        $post->save();
        //返回
        return redirect("/posts/{$post->id}");
    }

    // 删除
    public function delete(Post $post)
    {
        // TODO: 用户权限
        $post->delete();

        return redirect('/posts');
    }

    // 上传图片
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }
}

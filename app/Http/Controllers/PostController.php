<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Zan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // 列表页面
    public function index()
    {
        // 门面
//        \Log::info('post_index', ['data' => 'This is post log']);

        $posts = Post::orderBy('created_at', 'desc')->withCount(['comments', 'zans'])->paginate(6);
        // compact 变量传递到模板 或者直接在view方法里面第二个参数 写个数组 eg:view('post/index', ['posts' => $posts])
        return view('post/index', compact('posts'));
    }

    // 详情页
    public function show(Post $post)
    {
        $post->load('comments');
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

        $user_id = Auth::id();
        $parame = array_merge(request(['title', 'content']), compact('user_id'));

        Post::create($parame);

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
        $this->authorize('update', $post);
        $post->title = request('title');
        $post->content = request('content');

        $post->save();
        //返回
        return redirect("/posts/{$post->id}");
    }

    // 删除
    public function delete(Post $post)
    {
        // TODO: 用户权限
        $this->authorize('delete', $post);
        $post->delete();

        return redirect('/posts');
    }

    // 上传图片
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }

    // 创建评论
    public function comment(Post $post)
    {
        if (!empty(Auth::id())) {
            // 验证
            $this->validate(request(), [
                'content' => 'required|min:3'
            ]);
            // 逻辑
            $comment = new Comment();
            $comment->user_id = Auth::id();
            $comment->content = request('content');
            $post->comments()->save($comment);
            // 渲染
            return back();
        } else {
            return redirect('/login');
        }


    }

    // 赞
    public function zan(Post $post)
    {
        $param = [
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ];
        Zan::firstOrcreate($param);

        return back();
    }

    // 取消赞
    public function unzan(Post $post)
    {
        $post->zan(Auth::id())->delete();

        return back();
    }

    // 搜索页
    public function search()
    {
        DB::enableQueryLog();
        $keyword = request('query');
        $posts = DB::table('posts')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->where('title', 'LIKE', '%'.$keyword.'%')
            ->select('posts.*', 'users.name');
        $data = $posts->paginate(6);
        $data->appends(['query' => $keyword]);
        $count = $posts->count();
        return view('post/search', compact(['data', 'count', 'keyword']));
    }
}

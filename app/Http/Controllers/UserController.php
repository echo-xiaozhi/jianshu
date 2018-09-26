<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 个人主页
    public function show(User $user)
    {
        // 个人信息 包含 文章数量、粉丝数、关注人数
        $user = User::withCount(['posts', 'fans', 'stars'])->find($user->id);
        // 获取个人文章，列前十条
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();
        // 关注用户的 文章、粉丝、关注人数
        $stars = $user->stars();
        $susers = User::whereIn('id', $stars->pluck('star_id'))->withCount(['posts', 'fans', 'stars'])->get();
        // 粉丝的 文章、粉丝、关注人数
        $fans = $user->fans();
        $fusers = User::whereIn('id', $fans->pluck('fan_id'))->withCount(['posts', 'fans', 'stars'])->get();

        //渲染
        return view('user.show', compact('user', 'posts', 'susers', 'fusers'));
    }
    // 个人设置页面
    public function setting()
    {
        $user = Auth::user();
        return view('user.setting', compact('user'));
    }

    //个人设置实现
    public function settingStore(Request $request)
    {
        // 验证
        $this->validate(request(), [
            'name' => 'required|min:3',
        ]);
        // 逻辑
        $name = request('name');
        $user = Auth::user();
        if ($name !== $user->name) {
            if (User::where('name', $name)->count() > 0) {
                return back()->withErrors('用户名已经存在');
            }
            $user->name = $name;
        }

        if ($request->file('avatar')) {
            $path = $request->file('avatar')->storePublicly($user->id);
            $user->avatar = "/storage/" . $path;
        }
        $user->save();
        // 渲染
        return back();
    }
    // 关注
    public function fan(User $user)
    {
        $me = Auth::user();
        $me->dofan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }

    // 取消关注
    public function unfan(User $user)
    {
        $me = Auth::user();
        $me->undofan($user->id);
        return [
            'error' => 0,
            'msg' => ''
        ];
    }
}

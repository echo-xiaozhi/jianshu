<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 个人主页
    public function show()
    {
        return view('user.show');
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
    public function fan()
    {
        return;
    }

    // 取消关注
    public function unfan()
    {
        return ;
    }
}

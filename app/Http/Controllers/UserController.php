<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // 个人主页
    public function index()
    {
        return view('user.index');
    }
    // 个人设置页面
    public function setting()
    {
        return view('user.setting');
    }
}

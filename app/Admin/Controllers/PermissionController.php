<?php
namespace App\Admin\Controllers;


class PermissionController extends Controller
{
    // 权限列表
    public function index()
    {
        return view('admin.permission.index');
    }

    // 创建权限页面
    public function create()
    {
        return view('admin.permission.add');
    }

    // 创建权限行为
    public function store()
    {

    }
}
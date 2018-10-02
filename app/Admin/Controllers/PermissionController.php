<?php
namespace App\Admin\Controllers;


use App\AdminPermission;

class PermissionController extends Controller
{
    // 权限列表
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin.permission.index', compact('permissions'));
    }

    // 创建权限页面
    public function create()
    {
        return view('admin.permission.add');
    }

    // 创建权限行为
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        AdminPermission::create(request(['name', 'description']));

        return redirect('/admin/permissions');
    }

    // 修改权限页面
    public function update(AdminPermission $permission)
    {
        return view('admin.permission.edit', compact('permission'));
    }

    // 修改权限页面行为
    public function edit(AdminPermission $permission)
    {
        $this->validate(request(), [
            'description' => 'required'
        ]);

        $permission->description = request('description');
        $permission->save();

        return redirect('/admin/permissions');
    }

    // 删除权限
    public function delete(AdminPermission $permission)
    {
        $permission->delete();
        return back();
    }
}
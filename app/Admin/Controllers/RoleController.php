<?php
namespace App\Admin\Controllers;



use App\AdminPermission;
use App\AdminRole;

class RoleController extends Controller
{
    // 角色列表
    public function index()
    {
        $roles = AdminRole::paginate(10);
        return view('admin.role.index', compact('roles'));
    }

    // 创建角色页面
    public function create()
    {
        return view('admin.role.add');
    }

    // 创建角色行为
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        AdminRole::create(request(['name', 'description']));

        return redirect('/admin/roles');
    }

    // 修改权限页面
    public function update(AdminRole $role)
    {
        return view('admin.role.edit', compact('role'));
    }

    // 修改权限页面行为
    public function edit(AdminRole $role)
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required'
        ]);

        $role->name = request('name');
        $role->description = request('description');
        $role->save();

        return redirect('/admin/roles');
    }

    // 删除权限
    public function delete(AdminRole $role)
    {
        $role->delete();
        return back();
    }

    // 角色和权限关系页面
    public function permission(AdminRole $role)
    {
        // 获取所有权限
        $permissions = AdminPermission::all();
        // 获取当前角色权限
        $myPermissions = $role->permissions;
        return view('admin.role.permission', compact('permissions', 'myPermissions', 'role'));
    }

    // 储存角色和权限行为
    public function storePermission(AdminRole $role)
    {
        // 验证
        $this->validate(request(), [
            'permissions' => 'required|array'
        ]);

        //
        $permissions = AdminPermission::findMany(request('permissions'));
        $myPermissions = $role->permissions;

        // 比较要增加的
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $permission) {
            $role->grantPermission($permission);
        }

        // 比较 要删除的
        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission) {
            $role->deletePermission($permission);
        }

        return back();
    }
}
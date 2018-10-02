<?php
namespace App\Admin\Controllers;

use App\AdminRole;
use App\AdminUser;

class UserController extends Controller
{
    // 列表
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin.user.index', compact('users'));
    }
    // 增加
    public function create()
    {
        return view('admin.user.add');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'password' => 'required',
        ]);

        $name = request('name');
        $password = bcrypt(request('password'));
        AdminUser::firstOrCreate(compact('name', 'password'));

        return redirect('/admin/users');
    }
    // 修改
    public function update(AdminUser $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function edit(AdminUser $user)
    {
        //验证
        $this->validate(request(), [
            'password' => 'required|min:6',
        ]);
        $user->password = bcrypt(request('password'));
        $user->save();

        return redirect('/admin/users');
    }

    public function delete(AdminUser $user)
    {
        $user->delete();
        return back();
    }

    // 用户角色页面
    public function role(AdminUser $user)
    {
        $roles = AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role', compact('roles', 'myRoles', 'user'));
    }

    // 储存用户角色
    public function storeRole(AdminUser $user)
    {
        $this->validate(request(), [
            'roles' => 'required|array',
        ]);

        $roles = AdminRole::findMany(request('roles'));
        $myRoles = $user->roles;

        // 要增加的
        $addRoles = $roles->diff($myRoles);
        foreach ($addRoles as $role) {
            $user->assginRole($role);
        }

        // 要删除的
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }

        return back();

    }


}
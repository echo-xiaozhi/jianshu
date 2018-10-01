<?php

namespace App;

use App\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    ////不可以注入的字段
    protected $guarded = [];
    use Notifiable;
    protected $rememberTokenName = '';

    // 用户有哪些角色
    public function roles()
    {
        // belongsToMany() 第一个参数是要关联的模型，第二个参数要关联的数据表，三当前模型的关联字段，四关联模型的关联字段
        // withPivot() 获取关联数据表的字段值
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    // 判断是否有某些角色
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    // 给用户分配角色
    public function assginRole($role)
    {
        return $this->roles()->save($role);
    }

    // 取消用户角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    // 判断用户是否有权限
    public function hasPermission($permission)
    {
        return $this->isInRoles($permission);
    }

}

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
}

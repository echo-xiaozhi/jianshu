<?php

namespace App;

use App\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //
    use Notifiable;
    protected $rememberTokenName = '';
}

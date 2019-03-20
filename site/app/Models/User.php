<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'hr';
    protected $table = 'b_member';
    public $timestamps = false;

    public function admin()
    {
        return $this->hasOne('App\Models\Admin', 'c_user', 'c_user');
    }

    public function isAdmin()
    {
        return isset($this->admin->c_user) ? true : false; 
    }
}

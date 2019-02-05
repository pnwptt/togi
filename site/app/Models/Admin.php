<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'b_togi_admin';
    protected $primaryKey = 'i_admin_id';
    public $timestamps = false;
}

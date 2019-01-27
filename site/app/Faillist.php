<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faillist extends Model
{
    protected $table = "b_fail_lists";
    protected $primaryKey = 'i_fail_lists_id';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'b_machines';
    protected $primaryKey = 'i_machines_id';
    public $timestamps = false;
}

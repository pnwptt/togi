<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $connection = 'btdb01';
    protected $table = 'v_acc_ord';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordFailure extends Model
{
    protected $table = 'b_record_failure';
    protected $primaryKey = 'i_record_failure_id';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordFailureDetail extends Model
{
    protected $table = 'b_record_failure_detail';
    protected $primaryKey = 'i_record_failure_detail_id';
    public $timestamps = false;
}
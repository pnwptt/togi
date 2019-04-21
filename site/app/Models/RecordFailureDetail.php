<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecordFailureDetail extends Model
{
    protected $table = 'b_record_failure_detail';
    protected $primaryKey = 'i_record_failure_detail_id';
    public $timestamps = false;

    static function getDetailByRecordId($i_record_id) {
        return RecordFailureDetail::where('i_record_id', $i_record_id)->get();
    }

    static function getDetailByRecordIdIn($ids) {
        return RecordFailureDetail::whereIn('i_record_id', $ids)->get();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecordFailure extends Model
{
    protected $table = 'b_record_failure';
    protected $primaryKey = 'i_record_failure_id';
    public $timestamps = false;

    static function getChecklistByRecordId($i_record_id) {
        return DB::table('b_record_failure')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_record_failure.i_errorcode_id')
            ->select(DB::raw('DISTINCT b_record_failure.i_errorcode_id, b_errorcode.*'))
            ->where('i_record_id', $i_record_id)
            ->get();
    }

    static function getChecklistByRecordIdIn($ids) {
        return DB::table('b_record_failure')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_record_failure.i_errorcode_id')
            ->select(DB::raw('DISTINCT b_record_failure.i_errorcode_id, b_errorcode.*'))
            ->whereIn('i_record_id', $ids)
            ->get();
    }

    static function getRecordItemByRecordId($i_record_id) {
        return DB::table('b_record_failure')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_record_failure.i_errorcode_id')
            ->where('i_record_id', $i_record_id)
            ->orderBy('i_record_failure_id', 'ASC')
            ->get();
    }

    static function getRecordItemByRecordIdIn($ids) {
        return DB::table('b_record_failure')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_record_failure.i_errorcode_id')
            ->whereIn('i_record_id', $ids)
            ->orderBy('i_record_failure_id', 'ASC')
            ->get();
    }
}

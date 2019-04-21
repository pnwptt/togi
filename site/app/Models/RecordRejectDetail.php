<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecordRejectDetail extends Model
{
    protected $table = 'b_record_reject_detail';
    protected $primaryKey = 'i_record_reject_detail_id';
    public $timestamps = false;

    static function getDetailByRecordId($i_record_id, $i_errorcode_type_id) {
        return DB::table('b_record_reject_detail')
            ->join('b_checklists', 'b_checklists.i_checklist_id', '=', 'b_record_reject_detail.i_checklist_id')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->where('i_record_id', $i_record_id)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->get();
    }

    static function getDetailByRecordIdIn($ids, $i_errorcode_type_id) {
        return DB::table('b_record_reject_detail')
            ->join('b_checklists', 'b_checklists.i_checklist_id', '=', 'b_record_reject_detail.i_checklist_id')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->whereIn('i_record_id', $ids)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->get();
    }
}
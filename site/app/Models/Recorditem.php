<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecordItem extends Model
{
    protected $table = 'b_record_item';
    protected $primaryKey = 'i_record_item_id';
    public $timestamps = false;

    static function getMachinesByRecordId($i_record_id) {
        $machineList = RecordItem::select(DB::raw('MAX(i_record_item_id) AS i_record_item_id, c_machine_no'))
            ->where('i_record_id', $i_record_id)
            ->groupBy('c_machine_no')
            ->orderBy('i_record_item_id', 'asc')
            ->distinct()
            ->get();
        foreach ($machineList as $value) {
            $list[] = $value->c_machine_no;
        }
        return $list;
    }

    static function getMachinesByRecordIdIn($ids) {
        $machineList = RecordItem::select(DB::raw('MAX(i_record_item_id) AS i_record_item_id, i_record_id, c_machine_no'))
            ->whereIn('i_record_id', $ids)
            ->groupBy('c_machine_no')
            ->groupBy('i_record_id')
            ->orderBy('i_record_item_id', 'asc')
            ->orderBy('i_record_id', 'asc')
            ->get();
        foreach ($machineList as $value) {
            $list[] = $value->c_machine_no;
        }
        return $list;
    }

    static function getRecordItemByRecordId($i_record_id, $i_errorcode_type_id) {
        return DB::table('b_record_item')
            ->join('b_checklists', 'b_checklists.i_checklist_id', '=', 'b_record_item.i_checklist_id')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->where('i_record_id', $i_record_id)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->orderBy('b_record_item.i_record_item_id', 'asc')
            ->get();
        }
        
        static function getRecordItemByRecordIdIn($ids, $i_errorcode_type_id) {
            return DB::table('b_record_item')
            ->join('b_checklists', 'b_checklists.i_checklist_id', '=', 'b_record_item.i_checklist_id')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->whereIn('i_record_id', $ids)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->orderBy('b_record_item.i_record_item_id', 'asc')
            ->get();
    }
}

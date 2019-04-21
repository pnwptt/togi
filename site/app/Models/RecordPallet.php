<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RecordPallet extends Model
{
    protected $table = 'b_record_pallet';
    protected $primaryKey = 'i_record_pallet_id';
    public $timestamps = false;

    static function getPalletByRecordId($i_record_id) {
        return RecordPallet::where('i_record_id', $i_record_id)->get();
    }

    static function getPalletByRecordIdIn($ids) {
        return RecordPallet::whereIn('i_record_id', $ids)->get();
    }
}

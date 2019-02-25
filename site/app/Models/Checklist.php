<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Checklist extends Model
{
    protected $table = 'b_checklists';
    protected $primaryKey = 'i_checklist_id';
    public $timestamps = false;

    public function getErrorcode()
    {
        return $this->belongsTo('App\Models\Errorcode', 'i_errorcode_id');
    }

    static function getChecklistByErrorcodeType($i_form_id, $i_errorcode_type_id)
    {
        return DB::table('b_checklists')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->join('b_errorcode_type', 'b_errorcode_type.i_errorcode_type_id', '=', 'b_errorcode.i_errorcode_type_id')
            ->where('i_form_id', $i_form_id)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->get();
    }
}

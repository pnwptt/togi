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

    static function getChecklistByFromId($i_form_id, $i_errorcode_type_id)
    {
        return DB::table('b_checklists')
            ->join('b_errorcode', 'b_errorcode.i_errorcode_id', '=', 'b_checklists.i_errorcode_id')
            ->where('i_form_id', $i_form_id)
            ->where('i_errorcode_type_id', $i_errorcode_type_id)
            ->where('i_checklist_deleted', 0)
            ->orderBy('b_errorcode.i_errorcode_id' , 'asc')
            ->get();
    }

    static function getChecklistByModelsId($i_models_id, $i_errorcode_type_id)
    {
        $form = Form::where('i_models_id', $i_models_id)->where('i_status', 1)->first();
        return Checklist::getChecklistByFromId($form->i_form_id, $i_errorcode_type_id);
    }

    static function getChecklistByFormId($i_form_id, $i_errorcode_type_id)
    {
        return Checklist::getChecklistByFromId($i_form_id, $i_errorcode_type_id);
    }
}

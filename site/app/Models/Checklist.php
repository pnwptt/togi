<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = "b_checklists";
    protected $primaryKey = 'i_checklist_id';
    public $timestamps = false;

    public function getErrorcode()
    {
        return $this->belongsTo('App\Models\Errorcode', 'i_errorcode_id');
    }
}

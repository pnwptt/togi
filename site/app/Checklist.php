<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = "b_checklists";
    protected $primaryKey = 'i_checklists_id';
    public $timestamps = false;

    public function getErrorcode()
    {
        return $this->belongsTo('App\Errorcode', 'i_errorcode_id');
    }
}

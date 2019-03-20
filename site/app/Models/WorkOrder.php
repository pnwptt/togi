<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $connection = 'btdb01';
    protected $table = 'v_wo';
    protected $primaryKey = 'i_errorcode_id';

    public function getType()
    {
        return $this->belongsTo('App\Models\ErrorcodeType', 'i_errorcode_type_id');
    }
}

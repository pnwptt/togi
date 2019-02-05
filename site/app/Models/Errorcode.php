<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Errorcode extends Model
{
    protected $table = 'b_errorcode';
    protected $primaryKey = 'i_errorcode_id';
    public $timestamps = false;

    public function getType()
    {
        return $this->belongsTo('App\Models\ErrorcodeType', 'i_errorcode_type_id');
    }
}

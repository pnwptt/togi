<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Errorcode extends Model
{
    protected $table = "b_errorcode";
    protected $primaryKey = 'i_errorcode_id';
    public $timestamps = false;

    public function getType()
    {
        return $this->belongsTo('App\ErrorcodeType', 'i_errorcode_type_id');
    }
}

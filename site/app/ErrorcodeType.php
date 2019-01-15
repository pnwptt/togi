<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorcodeType extends Model
{
    protected $table = "b_errorcode_type";
    protected $primaryKey = 'i_errorcode_type_id';
    public $timestamps = false;

}

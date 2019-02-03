<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = "b_record";
    protected $primaryKey = 'i_record_id';
    public $timestamps = false;
}

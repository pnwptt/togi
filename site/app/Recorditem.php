<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recorditem extends Model
{
    protected $table = "b_record_item";
    protected $primaryKey = 'i_record_item_id';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecordItem extends Model
{
    protected $table = 'b_record_item';
    protected $primaryKey = 'i_record_item_id';
    public $timestamps = false;
}

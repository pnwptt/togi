<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = "b_series";
    protected $primaryKey = 'i_series_id';
    public $timestamps = false;
}

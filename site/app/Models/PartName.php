<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartName extends Model
{
    protected $table = 'b_part_name';
    protected $primaryKey = 'i_part_name_id';
    public $timestamps = false;

    public function getSeries()
    {
        return $this->belongsTo('App\Models\Series', 'i_series_id');
    }
}

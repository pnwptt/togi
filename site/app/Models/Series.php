<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'b_series';
    protected $primaryKey = 'i_series_id';
    public $timestamps = false;

    public function getModels()
    {
        return $this->belongsTo('App\Models\Models', 'i_models_id');
    }
}

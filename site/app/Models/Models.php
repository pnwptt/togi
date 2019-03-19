<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    protected $table = 'b_models';
    protected $primaryKey = 'i_models_id';
    public $timestamps = false;

    public function getSeriesList()
    {
        return $this->hasMany('App\Models\Series', 'i_models_id');
    }
}

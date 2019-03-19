<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'b_forms';
    protected $primaryKey = 'i_form_id';
    public $timestamps = false;

    public function getModels()
    {
        return $this->belongsTo('App\Models\Models', 'i_models_id');
    }

    public function getChecklist()
    {
        return $this->hasMany('App\Models\Checklist', 'i_form_id');
    }
}

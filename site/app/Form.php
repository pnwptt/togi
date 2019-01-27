<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = "b_forms";
    protected $primaryKey = 'i_forms_id';
    public $timestamps = false;
}

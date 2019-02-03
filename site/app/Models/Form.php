<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = "b_forms";
    protected $primaryKey = 'i_form_id';
    public $timestamps = false;
}

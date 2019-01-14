<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = "b_checklists";
    protected $primaryKey = 'i_checklists_id';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerGrantQuota extends Model
{
    protected $table = 'cgm_limit';
    protected $primarykey = 'id';
    protected $fillable = ['title', 'quota', 'effective_date', 'duration', 'active', 'created_by', 'updated_by', 'deleted_by'];
}


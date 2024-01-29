<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceCategory extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'department_id'
    ];
}

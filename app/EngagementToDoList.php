<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementToDoList extends Model
{
    use SoftDeletes;

    protected $table = 'ems_todolist';
    protected $primarykey = 'id';
    protected $fillable = [
        'engagement_id', 'title', 'active','created_by', 'updated_by', 'deleted_by'
    ];
}

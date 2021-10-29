<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementStatus extends Model
{
    use SoftDeletes;

    protected $table = 'ems_status';
    protected $primarykey = 'id';
    protected $fillable = [
        'description', 'active', 'created_by', 'updated_by', 'deleted_by'
    ];
}

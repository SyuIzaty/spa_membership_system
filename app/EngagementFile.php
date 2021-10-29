<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementFile extends Model
{
    use SoftDeletes;

    protected $table = 'ems_file';
    protected $primarykey = 'id';
    protected $fillable = [
        'progress_id', 'engagement_id', 'upload', 'web_path', 'created_by', 'updated_by', 'deleted_by'
    ];
}

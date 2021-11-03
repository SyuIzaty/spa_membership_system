<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementManagement extends Model
{
    use SoftDeletes;

    protected $table = 'ems_engagement';
    protected $primarykey = 'id';
    protected $fillable = [
        'title', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function progress(){
        return $this->hasMany('App\EngagementProgress', 'engagement_id', 'id');
    }
}

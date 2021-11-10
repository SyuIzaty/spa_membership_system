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
        'title', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function progress()
    {
        return $this->hasMany('App\EngagementProgress', 'engagement_id', 'id');
    }

    public function getStatus()
    {
        return $this->hasOne('App\EngagementStatus','id','status');
    }

    public function member()
    {
        return $this->hasMany('App\EngagementMember', 'engagement_id', 'id');
    }

}

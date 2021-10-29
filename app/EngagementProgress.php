<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementProgress extends Model
{
    use SoftDeletes;

    protected $table = 'ems_progress';
    protected $primarykey = 'id';
    protected $fillable = [
        'engagement_id', 'remark', 'status', 'team_member','created_by', 'updated_by', 'deleted_by'
    ];

    public function getStatus()
    {
        return $this->hasOne('App\EngagementStatus','id','status');
    }

    public function memberDetails(){
        return $this->hasOne('App\User', 'id', 'created_by');
    }

}

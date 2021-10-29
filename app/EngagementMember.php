<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementMember extends Model
{
    use SoftDeletes;

    protected $table = 'ems_member';
    protected $primarykey = 'id';
    protected $fillable = [
        'engagement_id', 'staff_id', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function memberDetails(){
        return $this->hasOne('App\User', 'id', 'staff_id');
    }


}

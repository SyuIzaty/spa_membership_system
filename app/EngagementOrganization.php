<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementOrganization extends Model
{
    use SoftDeletes;

    protected $table = 'ems_organization';
    protected $primarykey = 'id';
    protected $fillable = [
        'engagement_id', 'no', 'name', 'phone', 'email', 'designation', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function organization(){
        return $this->hasMany('App\EngagementOrganization', 'id', 'engagement_id');
    }

}

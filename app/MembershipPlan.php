<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipPlan extends Model
{
    use SoftDeletes;

    protected $fillable = ['plan_name','plan_description','plan_price','plan_duration_month'];

    public function planServices()
    {
        return $this->hasMany('App\PlanService', 'plan_id', 'id');
    }
}

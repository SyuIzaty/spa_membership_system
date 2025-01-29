<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPlan extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','membership_id','plan_id','start_date','end_date', 'membership_payment', 'membership_payment_status'];

    public function membershipPlan()
    {
        return $this->hasOne('App\MembershipPlan', 'id', 'plan_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'user_id', 'user_id');
    }

    public function scopeActive($query)
    {
        return $query->where(function ($query) {
            $query->where('start_date', '<=', now())
                  ->where('end_date', '>=', now());
                //   ->orWhere('start_date', '>', now());
        });
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id','customer_name','customer_ic','customer_email','customer_phone','customer_gender',
                            'customer_address','customer_state','customer_postcode','customer_start_date'];

    public function customerPlans()
    {
        return $this->hasMany('App\CustomerPlan', 'user_id', 'user_id');
    }
}

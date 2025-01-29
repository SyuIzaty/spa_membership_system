<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $table = 'staffs';

    protected $primaryKey = 'id';

    protected $fillable = ['user_id','staff_ic','staff_name','staff_email', 'staff_phone','staff_gender','staff_address',
                            'staff_state','staff_postcode','staff_start_date','staff_end_date'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking', 'staff_id', 'user_id');
    }

}

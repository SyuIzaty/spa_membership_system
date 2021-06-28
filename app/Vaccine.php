<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaccine extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_vaccine';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'q1', 'q1_reason', 'q1_other_reason', 'q2', 'q3', 'q3_date', 'q3_reason', 'q3_effect', 'q3_effect_remark', 'q4', 'q4_date', 'q4_reason', 'q4_effect', 'q4_effect_remark'
    ];

    public function reasons()
    {
        return $this->hasOne('App\VaccineReason', 'id', 'q1_reason');
    }

    public function staffs()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'user_id');
    }
}

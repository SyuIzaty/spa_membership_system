<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudyPlanHeader extends Model
{
    use SoftDeletes;

    protected $table = 'study_plans_header';
    protected $primaryKey = 'id';
    protected $fillable = [
        'std_plan_id', 'std_hd_course', 'std_hd_type', 'std_hd_cr_hr'
    ];

    public function courses()
    {
        return $this->hasOne('App\Course','id','std_hd_course');
    }

    public function studyEl()
    {
        return $this->hasMany('App\StudyPlanElective', 'std_elec_hd_id');
    }

}

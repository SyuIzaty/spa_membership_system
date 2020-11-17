<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyPlanElective extends Model
{
    use SoftDeletes;

    protected $table = 'study_plans_elective';
    protected $primaryKey = 'id';
    protected $fillable = [
        'std_elec_hd_id', 'std_elec_course'
    ];

    public function courses()
    {
        return $this->hasOne('App\Course','id','std_elec_course');
    }

    public function studyHd()
    {
        return $this->belongsTo('App\StudyPlanHeader', 'std_elec_hd_id'); 
    }
}

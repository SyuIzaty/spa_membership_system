<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudyPlan extends Model
{
    use SoftDeletes;

    protected $table = 'study_plans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'plan_progs', 'plan_sm', 'plan_cr_hr_total', 'plan_stat', 'plan_semester'
    ];

    public function programs()
    {
        return $this->hasOne('App\Programme','id','plan_progs');
    }

    public function modes()
    {
        return $this->belongsTo('App\Mode','plan_sm');
    }
}

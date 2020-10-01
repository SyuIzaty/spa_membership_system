<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantResult extends Model
{

    protected $table = 'applicantresult';
    protected $fillable = ['id','applicant_id','type','subject','grade_id','cgpa','created_at','updated_at'];

    public function applicant()
    {
        return $this->belongsTo('App\Applicant');
    }

    public function grading()
    {
        return $this->hasOne('App\Grading');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject','subject_code','subject');
    }

    public function grades()
    {
        return $this->belongsTo('App\Grades','grade_id')->withDefault();
    }

    public function applicantAcademic()
    {
        return $this->hasOne('App\ApplicantAcademic','applicant_id','applicant_id');
    }

    public function qualifications()
    {
        return $this->hasOne('App\Qualification','id','type');
    }

    public function scopeResult($query)
    {
        return $query->with(['grades','subjects','applicantAcademic']);
    }

    public function scopeApplicantId($query, $id)
    {
        return $query->where('applicant_id',$id);
    }

    public function scopeSpm($query)
    {
        return $query->where('type','1');
    }

    public function scopeStpm($query)
    {
        return $query->where('type','2');
    }

    public function scopeStam($query)
    {
        return $query->where('type','3');
    }

    public function scopeUec($query)
    {
        return $query->where('type','4');
    }

    public function scopeAlevel($query)
    {
        return $query->where('type','5');
    }

    public function scopeOlevel($query)
    {
        return $query->where('type','6');
    }

}

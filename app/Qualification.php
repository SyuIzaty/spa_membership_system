<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $table = 'qualifications';

    protected $fillable = ['id','qualification_code','qualification_name','created_at','updated_at'];

    public function applicant()
    {
        return $this->hasMany('App\Applicant','id','applicant_id');
    }

    public function result()
    {
    	return $this->belongsTo('App\ApplicantResult','type','id');
    }

    public function academic()
    {
    	return $this->belongsTo('App\ApplicantAcademic','type','id');
    }
}

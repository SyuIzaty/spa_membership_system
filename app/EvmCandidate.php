<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvmCandidate extends Model
{
    use SoftDeletes;

    protected $fillable = ['programme_id','student_id','student_programme','student_session','student_tagline','img_name','img_size','img_path',
                            'cast_vote','verify_status','verify_date','verify_remark', 'verify_by','created_by','updated_by','deleted_by'];

    public function student()
    {
        return $this->hasOne('App\Student','students_id', 'student_id');
    }

    public function studentProgramme()
    {
        return $this->hasOne('App\Programme','id', 'student_programme');
    }

    public function programme()
    {
        return $this->hasOne('App\EvmProgramme','id', 'programme_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id', 'verify_by');
    }
}

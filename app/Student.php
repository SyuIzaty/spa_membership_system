<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'students';
    protected $fillable = ['students_name', 'students_ic', 'students_email', 'students_phone', 'students_nationality', 'students_marital',
                           'students_race', 'students_dob', 'students_programme', 'programme_status', 'students_gender', 'students_religion',
                           'students_major', 'intake_id', 'students_id', 'students_status','students_mode','current_session','professional_id','advisor_id','current_semester'];
    protected $primaryKey = 'id';

    public function programme()
    {
        return $this->belongsTo('App\Models\eVoting\Programme','students_programme','code');
    }

    public function candidates()
    {
        return $this->hasMany('App\Models\eVoting\Candidate', 'student_id', 'students_id');
    }


    public function votes()
    {
        return $this->hasMany('App\Models\eVoting\Vote', 'student_id', 'students_id');
    }


    public function state()
    {
        return $this->belongsTo('App\State', 'students_state', 'state_code');
    }

}

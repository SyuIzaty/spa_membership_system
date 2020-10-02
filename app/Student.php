<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // protected $connection = 'oracle';
    // protected $table = 'STUDENT_MAIN';
    // protected $primaryKey = 'SM_STUDENT_ID';
    // public $incrementing = false;

    protected $table = 'students';
    protected $fillable = ['students_name', 'students_ic', 'students_email', 'students_phone', 'students_nationality', 'students_marital', 'students_race', 'students_dob', 'students_programme', 'programme_status', 'students_gender', 'students_religion', 'students_major', 'intake_id'];
    protected $primaryKey = 'id';
    // protected $foreignKey = ['students_id', 'race_code', 'gender_code', 'religion_code'];   
    
    public function studentContactInfo()
    {
        return $this->hasOne('App\StudentContact','students_id'); //model StudentContact
    }

    public function race()
    {
        return $this->hasOne('App\Race','race_code', 'students_race'); //model Race; race_code (race column), students_race (race column in student)
    }

    public function gender()
    {
        return $this->hasOne('App\Gender','gender_code', 'students_gender'); 
    }

    public function religion()
    {
        return $this->hasOne('App\Religion','religion_code', 'students_religion'); 
    }

    public function programme()
    {
        return $this->hasOne('App\Programme','programme_code', 'students_programme'); 
    }

    public function studentGuardian()
    {
        return $this->hasOne('App\StudentGuardian','students_id'); 
    }

    public function studentEmergency()
    {
        return $this->hasOne('App\StudentEmergency','students_id'); 
    }
    
}
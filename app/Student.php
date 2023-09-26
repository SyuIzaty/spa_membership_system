<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'students';
    public function __construct()
    {
        $this->table = DB::connection($this->connection)->getDatabaseName() . '.' . $this->table;
    }
    protected $fillable = ['students_name', 'students_ic', 'students_email', 'students_phone', 'students_nationality', 'students_marital',
                            'students_race', 'students_dob', 'students_programme', 'students_gender', 'students_religion', 'students_uni',
                            'students_major', 'intake_id', 'students_id', 'students_status','students_mode','current_session','advisor_id',
                            'current_semester','students_graduation','batch_code', 'students_address_1', 'students_address_2', 'students_postcode', 'students_city',
                            'students_state','students_country', 'sponsor_id', 'plan_id', 'student_bank', 'student_account_no', 'household_income', 'students_senate',
                            'clearance_status','withdraw_date','intake_code', 'start_study', 'end_study','remark','students_qualification',
                            'students_returning','students_parliament','students_dun','installment'];
    protected $primaryKey = 'id';

    public function programme()
    {
        return $this->belongsTo('App\Models\eVoting\Programme', 'students_programme', 'code');
    }

    public function programmes()
    {
        return $this->hasOne('App\Programme', 'id', 'students_programme');
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

    public function gender()
    {
        return $this->hasOne('App\Gender', 'gender_code', 'students_gender');
    }
}

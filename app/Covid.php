<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Covid extends Model
{
    use SoftDeletes;
    protected $table = 'cdd_covid_declarations';
    protected $dates = ['declare_date'];
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'user_ic', 'user_phone','user_name','user_email','user_position','department_id',
        'form_type', 'q1', 'q2', 'q3', 'q4a', 'q4b', 'q4c', 'q4d', 'confirmation', 'category', 
        'created_by', 'declare_date', 'declare_time', 'user_category', 'temperature'
    ];

    public function user()
    {
        return $this->hasOne('App\User','id', 'user_id');
    }

    public function type()
    {
        return $this->hasOne('App\UserType', 'user_code', 'user_position');
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'department_id');
    }

    public function categoryUser()
    {
        return $this->hasOne('App\UserCategory', 'category_code', 'user_category');
    }

    public function students()
    {
        return $this->hasOne('App\Student','students_id', 'user_id');
    }

    public function staffs()
    {
        return $this->hasOne('App\Staff','staff_id', 'user_id');
    }

    public function scopeUnderQuarantine($query)
    {        
        return $query->select('user_id')->where('category', 'A')->where( 'declare_date', '>', Carbon::now()->subDays(14))->orWhere(function ($query) {
            $query->select('user_id')->where('category', 'B')->where( 'declare_date', '>', Carbon::now()->subDays(10));
        });
    }
}

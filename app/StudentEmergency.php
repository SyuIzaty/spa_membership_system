<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentEmergency extends Model
{
    protected $table = 'students_emergency';
    protected $fillable = ['students_id', 'emergency_name','emergency_phone','emergency_address','emergency_relationship'];
    protected $foreignKey = 'students_id';

    public function student()
    {
        return $this->belongsTo('App\Student','students_id','id');
    }
}

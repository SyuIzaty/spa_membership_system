<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class eKenderaanPassengers extends Model
{
    use SoftDeletes;
    protected $table = 'ekn_passengers';
    protected $fillable = [
        'ekn_details_id', 'intec_id', 'category','created_by', 'updated_by', 'deleted_by'
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'students_id', 'intec_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id', 'intec_id');
    }
}

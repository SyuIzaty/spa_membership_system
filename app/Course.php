<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $table = 'courses';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'course_code', 'course_name', 'credit_hours', 'course_status'
    ];

    protected $attributes = [
        'course_status' => 1
    ];

    public function getActiveAttribute($attribute)
    {
        return [
            0 => 'Inactive',
            1 => 'Active'
        ] [$attribute];
    }

    public function scopeActive($query)
    {
    	return $query->where('course_status', 1);
    }

    public function scopeInactive($query)
    {
    	return $query->where('course_status', 0);
    }

    // protected $connection = 'oracle';
    // protected $table = 'COURSE_MAIN';
    // protected $primaryKey = 'CM_COURSE_CODE';
    // public $incrementing = false;
}

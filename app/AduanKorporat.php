<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporat extends Model
{
    use SoftDeletes;
    protected $table = 'eak_complaint';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ticket_no', 'staff_id', 'student_id', 'name', 'ic', 'phone_no', 'address','email','user_category',
        'category', 'status', 'assign', 'title', 'description', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function getStatus()
    {
        return $this->hasOne('App\AduanKorporatStatus','id','status');
    }

    public function getUserCategory()
    {
        return $this->hasOne('App\AduanKorporatUser','code','user_category');
    }

    public function getCategory()
    {
        return $this->hasOne('App\AduanKorporatCategory','id','category');
    }

    public function getDepartment()
    {
        return $this->hasOne('App\DepartmentList','id','assign');
    }

    public function getLog()
    {
        return $this->hasMany('App\AduanKorporatLog','complaint_id','id');
    }

    public function getRemark()
    {
        return $this->hasOne('App\AduanKorporatRemark','complaint_id','id');
    }

    public function countPending()
    {
        return $this->where('status', 1)->count();
    }

    public function countAssigned()
    {
        return $this->where('status', 2)->count();
    }

    public function countAction()
    {
        return $this->where('status', 3)->count();
    }

    public function countCompleted()
    {
        return $this->where('status', 4)->count();
    }
}

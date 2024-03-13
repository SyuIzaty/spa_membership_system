<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskMain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category',
        'type_id',
        'detail',
        'department_id',
        'start_date',
        'end_date',
        'progress_id',
        'priority_id',
        'comment',
        'email_sent'
    ];

    public function taskUser()
    {
        return $this->hasOne('App\TaskUser','id','user_id');
    }

    public function taskCategory()
    {
        return $this->hasOne('App\TaskCategory','id','category_id');
    }

    public function taskType()
    {
        return $this->hasOne('App\TaskType','id','type_id');
    }

    public function departmentList()
    {
        return $this->hasOne('App\DepartmentList','id','department_id');
    }

    public function progressStatus()
    {
        return $this->hasOne('App\TaskStatus','id','progress_id');
    }

    public function priorityStatus()
    {
        return $this->hasOne('App\TaskStatus','id','priority_id');
    }

    public function scopeProgressId($query, $progress_id)
    {
        return $query->where('progress_id',$progress_id);
    }

    public function scopePriorityId($query, $priority_id)
    {
        return $query->where('priority_id',$priority_id);
    }
}

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
}

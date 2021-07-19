<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventStatus extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function events()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Event',
        'event_status_id', 'id');
    }
}

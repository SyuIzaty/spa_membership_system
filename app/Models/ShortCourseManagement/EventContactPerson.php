<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventContactPerson extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_contact_person';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'contact_person_id',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function event()
    {
        //Paramenet 1 belongs to parameter 0
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'event_id', 'id');
    }

    public function contact_person()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\ContactPerson', 'contact_person_id', 'id');
    }

}

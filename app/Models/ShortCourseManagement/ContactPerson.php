<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactPerson extends Model
{
    use SoftDeletes;
    protected $table = 'scm_contact_person';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'ic',
        'phone',
        'email',
        'description',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function events_contact_persons()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventContactPerson', 'contact_person_id', 'id');
    }
}

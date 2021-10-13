<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use SoftDeletes;
    protected $table = 'scm_participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'ic',
        'sha1_ic',
        'phone',
        'email',
        'gender',
        'first_name',
        'last_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function events_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipant',
        'participant_id',
        'id');
    }

    public function organisations_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\OrganisationParticipant', 'participant_id', 'id');
    }
}

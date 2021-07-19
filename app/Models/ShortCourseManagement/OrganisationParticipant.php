<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganisationParticipant extends Model
{
    use SoftDeletes;
    protected $table = 'scm_organisation_participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'organisation_id',
        'participant_id',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function organisation()
    {
        //Paramenet 1 belongs to parameter 0
        return $this->belongsTo('App\Models\ShortCourseManagement\Organisation',
        'organisation_id',
        'id');
    }

    public function participant()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Participant',
        'participant_id',
        'id');
    }
}

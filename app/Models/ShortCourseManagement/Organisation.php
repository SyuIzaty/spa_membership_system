<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model
{
    use SoftDeletes;
    protected $table = 'scm_organisation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function organisations_trainers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\OrganisationTrainer', 'organisation_id', 'id');
    }

    public function organisations_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\OrganisationParticipant', 'organisation_id', 'id');
    }
}

<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganisationTrainer extends Model
{
    use SoftDeletes;
    protected $table = 'scm_organisation_trainer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'organisation_id', 'trainer_id', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function organisation()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Organisation', 'id', 'organisation_id');
    }

    public function trainer()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Trainer', 'id', 'trainer_id');
    }
}

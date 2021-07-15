<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainer extends Model
{
    use SoftDeletes;
    protected $table = 'scm_trainer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'ic', 'phone', 'description','created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'id');
    }

    public function events_trainers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventTrainer', 'trainer_id', 'id');
    }

    public function organisations_trainers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\OrganisationTrainer', 'trainer_id', 'id');
    }
}

<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventTrainer extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_trainer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'trainer_id',
        'trainer_representative_id',
        'is_done_paid',
        'payment_proof_path',
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
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'id', 'event_id');
    }

    public function trainer()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Trainer', 'id', 'trainer_id');
    }

    public function trainer_representative()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventTrainer', 'id', 'trainer_representative_id');
    }

}

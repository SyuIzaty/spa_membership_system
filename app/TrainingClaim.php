<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingClaim extends Model
{
    use SoftDeletes;
    protected $table = 'trm_claim';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id', 'training_id', 'title', 'type', 'category', 'start_date', 'start_time', 'end_date', 'end_time', 'venue', 'link', 'claim_hour', 'approved_hour', 'status', 'reject_reason',
        'assigned_by','form_type'
    ];

    public function staffs()
    {
        return $this->hasOne('App\Staff', 'staff_id', 'staff_id');
    }

    public function trainings()
    {
        return $this->hasOne('App\TrainingList', 'id', 'training_id');
    }

    public function users()
    {
        return $this->hasOne('App\User', 'id', 'assigned_by');
    }

    public function types()
    {
        return $this->hasOne('App\TrainingType', 'id', 'type');
    }

    public function categories()
    {
        return $this->hasOne('App\TrainingCategory', 'id', 'category');
    }

    public function claimStatus()
    {
        return $this->hasOne('App\TrainingStatus', 'id', 'status')->where('status_type','TC');
    }
}

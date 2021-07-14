<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;
    protected $table = 'scm_fee';
    protected $primaryKey = 'id';
    protected $fillable = [
        'is_base_fee', 'promo_code','promo_end_datetime','name','event_id','amount','is_active', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function events()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'id', 'event_id');
    }

    public function events_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipant', 'fee_id', 'id');
    }
}

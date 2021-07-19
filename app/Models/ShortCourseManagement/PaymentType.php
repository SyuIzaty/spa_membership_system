<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{
    use SoftDeletes;
    protected $table = 'scm_payment_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
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
        'payment_type_id',
        'id');
    }
}

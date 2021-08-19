<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VenueType extends Model
{
    use SoftDeletes;
    protected $table = 'scm_venue_type';
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

    public function events()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Venue',
        'venue_type_id',
        'id');
    }
}

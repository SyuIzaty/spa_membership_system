<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowType extends Model
{
    use SoftDeletes;
    protected $table = 'follow_type';
    protected $primaryKey = 'id';
    protected $fillable = [
        'follow_code', 'follow_name'
    ];

    public function lead_notes()
    {
        return $this->hasMany('App\LeadNote'); 
    }
}

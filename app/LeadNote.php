<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadNote extends Model
{
    use SoftDeletes;
    protected $table = 'leads_note';
    protected $primaryKey = 'id';
    protected $fillable = [
        'leads_id', 'follow_type_id', 'follow_date', 'follow_remark', 'status_id'
    ];

    public function follow_types()
    {
        return $this->belongsTo('App\FollowType','follow_type_id');  
    }
}

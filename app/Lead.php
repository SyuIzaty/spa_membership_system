<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    protected $table = 'leads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'leads_name', 'leads_email', 'leads_phone', 'leads_ic', 'leads_source', 'leads_event', 'edu_level', 'leads_prog1', 'leads_prog2', 'leads_prog3', 'leads_status', 'created_by', 'assigned_to'
    ];

    public function lead_status()
    {
        return $this->belongsTo('App\LeadStatus','leads_status');  
    }

    public function lead_notes()
    {
        return $this->hasMany('App\LeadNote','leads_id');  
    }

    public function user()
    {
        return $this->belongsTo('App\User','assigned_to');  
    }

    public function qualify()
    {
        return $this->hasMany('App\Qualification','edu_level');
    }

}
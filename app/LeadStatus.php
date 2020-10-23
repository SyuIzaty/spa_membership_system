<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadStatus extends Model
{
    use SoftDeletes;
    protected $table = 'leads_status';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status_code', 'status_name'
    ];

    public function lead()
    {
        return $this->hasMany('App\Lead'); 
    }

}

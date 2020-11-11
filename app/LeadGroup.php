<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadGroup extends Model
{
    use SoftDeletes;
    protected $table = 'leads_group';
    protected $primaryKey = 'id';
    protected $fillable = [
        'group_code', 'group_name', 'group_desc', 'group_status'
    ];

    public function lead()
    {
        return $this->hasMany('App\Lead'); 
    }

}

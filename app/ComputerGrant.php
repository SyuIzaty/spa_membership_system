<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerGrant extends Model
{
    use SoftDeletes;
    protected $table = 'cgm_permohonan';
    protected $primarykey = 'id';
    protected $fillable = [
        'ticket_no', 'staff_id', 'hp_no', 'office_no', 'status', 'grant_amount', 'type',
        'price', 'brand', 'model', 'serial_no', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function getStatus()
    {
        return $this->hasMany('App\ComputerGrantStatus','id','status');  
    }

    public function getType()
    {
        return $this->hasOne('App\ComputerGrantType','id','type');  
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','staff_id');
    }


}


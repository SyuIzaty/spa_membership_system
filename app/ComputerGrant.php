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
        'price', 'brand', 'model', 'serial_no', 'active', 'grant_id', 'remark', 'expiry_date', 'approved_by', 'approved_at', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function getStatus()
    {
        return $this->hasOne('App\ComputerGrantStatus','id','status');
    }

    public function getType()
    {
        return $this->hasOne('App\ComputerGrantType','id','type');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','staff_id');
    }

    public function getProof(){
        return $this->hasMany('App\ComputerGrantPurchaseProof', 'permohonan_id', 'id');
    }

    public function getFail(){
        return $this->hasMany('App\ComputerGrantFile', 'permohonan_id', 'id');
    }

    public function getLog(){
        return $this->hasMany('App\ComputerGrantLog', 'permohonan_id', 'id');
    }

    public function getQuota()
    {
        return $this->hasOne('App\ComputerGrantQuota','id','grant_id');
    }

    public function countPending()
    {
        return $this->where('status',1)->count();
    }

    public function countPurchase()
    {
        return $this->where('status',2)->count();
    }

    public function countPendingVerifyPurchase()
    {
        return $this->where('status',3)->count();
    }

    public function countPurchaseVerified()
    {
        return $this->where('status',4)->count();
    }

    public function countSigned()
    {
        return $this->where('status',5)->count();
    }

    public function countReimbursement()
    {
        return $this->where('status',6)->count();
    }

    public function countRequestCancel()
    {
        return $this->where('status',7)->count();
    }

    public function countCancelVerified()
    {
        return $this->where('status',8)->count();
    }
}


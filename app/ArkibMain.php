<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibMain extends Model
{
    use SoftDeletes;

    protected $fillable = ['department_code','title','description','status','created_at'];

    public function arkibStatus()
    {
        return $this->hasOne('App\ArkibStatus','arkib_status','status');
    }

    public function arkibAttachments()
    {
        return $this->hasMany('App\ArkibAttachment','arkib_main_id','id');
    }

    public function department()
    {
        return $this->hasOne('App\Departments','department_code','department_code');
    }

    public function scopeUnpublished($query)
    {
        return $query->where('status','U');
    }

    public function scopePublished($query)
    {
        return $query->where('status','P');
    }
}

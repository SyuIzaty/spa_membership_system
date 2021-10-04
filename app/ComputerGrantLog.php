<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComputerGrantLog extends Model
{
    protected $table = 'cgm_log_activity';
    protected $primarykey = 'id';
    protected $fillable = ['permohonan_id', 'activity', 'created_by', 'updated_by', 'deleted_by'];

    public function grant()
    {
        return $this->hasMany('App\ComputerGrant', 'id', 'permohonan_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','created_by');
    }


}

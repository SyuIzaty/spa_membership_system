<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatLog extends Model
{
    protected $table = 'eak_log_activity';
    protected $primarykey = 'id';
    protected $fillable = ['complaint_id','name', 'activity', 'created_by', 'updated_by', 'deleted_by'];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'id', 'complaint_id');
    }

}

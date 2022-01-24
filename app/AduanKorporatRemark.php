<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatRemark extends Model
{
    protected $table = 'eak_remark';
    protected $primarykey = 'id';
    protected $fillable = ['complaint_id', 'remark', 'admin_remark', 'created_by', 'updated_by', 'deleted_by'];

    public function staff()
    {
        return $this->hasOne('App\Staff','staff_id','created_by');
    }

    public function staffAdmin()
    {
        return $this->hasOne('App\Staff','staff_id','updated_by');
    }

}

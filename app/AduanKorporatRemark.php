<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AduanKorporatRemark extends Model
{
    protected $table = 'eak_remark';
    protected $primarykey = 'id';
    protected $fillable = ['complaint_id', 'remark', 'admin_remark', 'created_by', 'updated_by', 'deleted_by'];
}

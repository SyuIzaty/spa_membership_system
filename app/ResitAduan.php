<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResitAduan extends Model
{
    use SoftDeletes;
    protected $table = 'cms_resit_aduan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_aduan', 'nama_fail', 'saiz_fail', 'web_path'
    ];
}

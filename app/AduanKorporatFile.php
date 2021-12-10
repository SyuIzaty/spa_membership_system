<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AduanKorporatFile extends Model
{
    use SoftDeletes;

    protected $table = 'eak_file';
    protected $primarykey = 'id';
    protected $fillable = [
        'complaint_id', 'original_name', 'upload', 'web_path', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function getData()
    {
        return $this->hasMany('App\AduanKorporat', 'id', 'complaint_id');
    }
}

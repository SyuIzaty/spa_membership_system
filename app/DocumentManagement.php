<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DocumentManagement extends Model
{
    use SoftDeletes;

    protected $table = 'dms_file';
    protected $primarykey = 'id';
    protected $fillable = [
        'department_id', 'category', 'upload', 'title', 'original_name', 'web_path', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function department()
    {
        return $this->hasOne('App\DepartmentList', 'id', 'department_id');
    }

    public function getCategory()
    {
        return $this->hasOne('App\DocumentCategory', 'id', 'category');
    }

}

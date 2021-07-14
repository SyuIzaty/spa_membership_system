<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'scm_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function SubCategories()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\SubCategory', 'category_id', 'id');
    }
}

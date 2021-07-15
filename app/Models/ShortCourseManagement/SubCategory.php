<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $table = 'scm_subcategory';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'category_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Category', 'category_id', 'id');
    }

    public function topics()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Topic', 'subcategory_id', 'id');
    }
}

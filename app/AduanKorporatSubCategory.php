<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AduanKorporatSubCategory extends Model
{
    use SoftDeletes;

    protected $table = 'eak_subcategory';
    protected $primarykey = 'id';
    protected $fillable = ['description','active','created_by','updated_by','deleted_by'];

    public function complaint()
    {
        return $this->hasMany('App\AduanKorporat', 'category', 'id');
    }
}

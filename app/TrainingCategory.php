<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingCategory extends Model
{
    use SoftDeletes;
    protected $table = 'trm_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_name'
    ];

    public function claims()
    {
        return $this->hasMany('App\TrainingClaim','category');  
    }
}

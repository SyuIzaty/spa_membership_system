<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoRequisite extends Model
{
    use SoftDeletes;

    protected $table = 'co_requisites';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'courses_id', 'co_requisite_course'
    ];

    public function course()
    {
        return $this->hasMany('App\Course','id');  
    }

}

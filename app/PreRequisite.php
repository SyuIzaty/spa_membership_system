<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreRequisite extends Model
{
    use SoftDeletes;

    protected $table = 'pre_requisites';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'courses_id', 'pre_requisite_course'
    ];

    public function course()
    {
        return $this->hasMany('App\Course','id');  
    }

}

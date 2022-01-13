<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgrammeCategory extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'programmes_category';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function programmes()
    {
        return $this->hasMany('App\Programme', 'programme_category_id', 'id');
    }
}

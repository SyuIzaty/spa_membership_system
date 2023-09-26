<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gender extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql2';
    protected $table = 'genders';
    protected $fillable = ['gender_code', 'gender_name'];
    protected $primaryKey = 'gender_code';

    public function student()
    {
        return $this->belongsTo('App\Student','gender_code');
    }
}

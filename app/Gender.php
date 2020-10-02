<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $table = 'genders';
    protected $fillable = ['gender_code', 'gender_name'];
    protected $primaryKey = 'gender_code';
    // protected $foreignKey = 'gender_code';

    public $incrementing = false;
    protected $keyType = 'string';

    public function student()
    {
        return $this->belongsTo('App\Student','gender_code');
    }
}
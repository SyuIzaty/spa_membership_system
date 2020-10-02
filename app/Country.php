<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['country_code', 'country_name'];
    protected $primaryKey = 'country_code';

    public $incrementing = false;
    protected $keyType = 'string';

    public function studentContactInfo()
    {
        return $this->belongsTo('App\StudentContact','country_code');
    }
}
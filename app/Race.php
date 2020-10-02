<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $table = 'races';
    protected $fillable = ['race_code', 'race_name'];
    protected $primaryKey = 'race_code';
    // protected $foreignKey = 'race_code';

    public $incrementing = false;
    protected $keyType = 'string';

    public function student()
    {
        return $this->belongsTo('App\Student','race_code');
    }
}
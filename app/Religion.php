<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{
    protected $table = 'religions';
    protected $fillable = ['religion_code', 'religion_name'];
    protected $primaryKey = 'religion_code';
    // protected $foreignKey = 'religion_code';

    public $incrementing = false;
    protected $keyType = 'string';

    public function student()
    {
        return $this->belongsTo('App\Student','religion_code');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $fillable = ['state_code', 'state_name'];
    protected $primaryKey = 'state_code';

    public $incrementing = false;
    protected $keyType = 'string';

    public function studentContactInfo()
    {
        return $this->belongsTo('App\StudentContact','state_code');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;

    protected $fillable = ['batch_code', 'batch_name', 'batch_description', 'status'];

    public function intakeDetail()
    {
        return $this->hasMany('App\IntakeDetail', 'batch_code', 'batch_code');
    }
}

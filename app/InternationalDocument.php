<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternationalDocument extends Model
{
    use SoftDeletes;

    protected $fillable = ['applicant_id', 'file_name', 'file_type', 'file_size', 'web_path'];

    public function applicant()
    {
        return $this->hasOne('App\Applicant','id','applicant_id');
    }
}

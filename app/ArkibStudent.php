<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArkibStudent extends Model
{
    use SoftDeletes;

    protected $fillable = ['arkib_id','student_id'];

    public function arkibMain()
    {
        return $this->hasOne('App\ArkibMain','id','arkib_id');
    }

    public function student()
    {
        return $this->hasOne('App\Student','students_id','student_id');
    }

    public function scopeArkibId($query, $arkib_id)
    {
        return $query->where('arkib_id',$arkib_id);
    }
}

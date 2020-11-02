<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    protected $table = 'students_guardian';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [ 'id','guardian_one_name','guardian_one_relationship','guardian_one_mobile','guardian_one_addresss',
                            'guardian_two_name','guardian_two_relationship','guardian_two_mobile','guardian_two_addresss'];

    public function student()
    {
        return $this->belongsTo('App\Student','students_id','id');
    }
}

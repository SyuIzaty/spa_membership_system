<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantGuardian extends Model
{
    protected $table = 'applicant_guardian';

    protected $fillable = ['applicant_id', 'guardian_one_name','guardian_one_relationship','guardian_one_mobile','guardian_one_address'
                            , 'guardian_two_name','guardian_two_relationship','guardian_two_mobile','guardian_two_address'];

    public function familyOne()
    {
        return $this->hasOne('App\Family','family_code','guardian_one_relationship');
    }

    public function familyTwo()
    {
        return $this->hasOne('App\Family','family_code','guardian_two_relationship');
    }
}

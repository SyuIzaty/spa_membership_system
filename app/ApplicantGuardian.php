<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicantGuardian extends Model
{
    protected $table = 'applicant_guardian';

    protected $fillable = ['applicant_id', 'guardian_one_name','guardian_one_relationship','guardian_one_ic','guardian_one_mobile','guardian_one_address','guardian_one_occupation','guardian_one_nationality'
                            , 'guardian_two_name','guardian_two_relationship','guardian_two_ic','guardian_two_mobile','guardian_two_address','guardian_two_occupation','guardian_two_nationality'];
}

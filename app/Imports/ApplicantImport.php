<?php

namespace App\Imports;

use App\Applicant;
use App\ApplicantContact;
use App\ApplicantGuardian;
use App\Intakes;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class ApplicantImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $intakes = Intakes::where('status','1')->first();
        $applicant = Applicant::create([
            'applicant_name' => $row['name'],
            'applicant_email' => $row['email'],
            'applicant_phone' => $row['phone'],
            'applicant_ic' => $row['ic'],
            'applicant_gender' => $row['gender'],
            'applicant_race' => $row['race'],
            'applicant_religion' => $row['religion'],
            'intake_id' => $intakes['id'],
            'applicant_status' => '00',
        ]);

        ApplicantContact::create([
            'applicant_id' => $applicant['id'],
            'applicant_address_1' => $row['applicant_address_1'],
            'applicant_address_2' => $row['applicant_address_2'],
            'applicant_poscode' => $row['postcode'],
            'applicant_city' => $row['district'],
            'applicant_state' => $row['state'],
        ]);

        ApplicantGuardian::create([
            'applicant_id' => $applicant['id'],
            'guardian_one_name' => $row['father_name'],
            'guardian_one_mobile' => $row['father_phone'],
            'guardian_one_address' => $row['father_address'],
            'guardian_two_name' => $row['mother_name'],
            'guardian_two_mobile' => $row['mother_phone'],
            'guardian_two_address' => $row['mother_address'],
        ]);
    }
}

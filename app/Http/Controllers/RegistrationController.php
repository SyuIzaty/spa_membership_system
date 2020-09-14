<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Country;
use App\Programme;
use App\Major;
use App\State;
use App\Gender;
use App\Marital;
use App\Race;
use App\Religion;
use App\ApplicantContact;
use App\ApplicantEmergency;
use App\ApplicantGuardian;
use App\Qualification;
use App\ApplicantAcademic;
use App\Subject;
use App\Grades;
use App\ApplicantResult;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\StoreApplicantDetailRequest;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::all();
        $programme = Programme::all();
        $major = Major::all();
        $state = State::all();
        return view('registration.index', compact('country','programme','major'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicantRequest $request)
    {
        $detail = Applicant::create($request->all());

        $applicant_detail = Applicant::where('applicant_ic',$request->applicant_ic)->with(['country','programme','programmeTwo','programmeThree','majorOne','majorTwo','majorThree'])->first();

        return redirect()->route('printRef', ['id' => $request->applicant_ic]);
    }

    public function printRef($id)
    {
        $applicant_detail = Applicant::where('applicant_ic',$id)->with(['applicantContactInfo','applicantContactInfo.country','programme','programmeTwo','programmeThree','majorOne','majorTwo','majorThree'])->first();
        return view('registration.printRef', compact('applicant_detail'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::where('id', $id)->with(['applicantContactInfo','applicantEmergency'])->first();
        $country = Country::all();
        $gender = Gender::all();
        $state = State::all();
        $marital = Marital::all();
        $race = Race::all();
        $religion = Religion::all();
        $subjectSpmArr = $subjectSpmAGradeArr = $subjectStamArr = $subjectStamAGradeArr = [];
        $subjectUecArr = $subjectUecAGradeArr = [];
        $subjectStpmArr = $subjectStpmAGradeArr = [];
        $subjectOlevelArr = $subjectOlevelAGradeArr = [];

        $qualification = Qualification::all();
        $subjectspm = Subject::where('qualification_type', '1')->get();
        $gradeSpm = Grades::where('grade_type', '1')->get();
        foreach ($subjectspm as $subspm) {
            $subjectSpmArr[] = [
                $subspm->subject_code,
                $subspm->subject_name
            ];
        }
        foreach ($gradeSpm as $rspm) {
            $subjectSpmAGradeArr[] = [
                $rspm->id,
                $rspm->grade_code
            ];
        }

        $subjectstam = Subject::where('qualification_type', '3')->get();
        $gradeStam = Grades::where('grade_type', '3')->get();
        foreach ($subjectstam as $substam) {
            $subjectStamArr[] = [
                $substam->subject_code,
                $substam->subject_name
            ];
        }
        foreach ($gradeStam as $rstam) {
            $subjectStamAGradeArr[] = [
                $rstam->id,
                $rstam->grade_code
            ];
        }

        $subjectstpm = Subject::where('qualification_type', '2')->get();
        $gradeStpm = Grades::where('grade_type', '2')->get();
        foreach($subjectstpm as $substpm) {
            $subjectStpmArr[] = [
                $substpm->subject_code,
                $substpm->subject_name
            ];
        }
        foreach ($gradeStpm as $rstpm) {
            $subjectStpmAGradeArr[] = [
                $rstpm->id,
                $rstpm->grade_code
            ];
        }

        $subjectolevel = Subject::where('qualification_type', '6')->get();
        $gradeOlevel = Grades::where('grade_type', '6')->get();
        foreach ($subjectolevel as $subolevel) {
            $subjectOlevelArr[] = [
                $subolevel->subject_code,
                $subolevel->subject_name
            ];
        }
        foreach ($gradeOlevel as $rolevel) {
            $subjectOlevelAGradeArr[] = [
                $rolevel->id,
                $rolevel->grade_code
            ];
        }

        $subjectalevel = Subject::where('qualification_type', '5')->get();
        $gradeAlevel = Grades::where('grade_type', '5')->get();
        foreach ($subjectalevel as $subalevel) {
            $subjectAlevelArr[] = [
                $subalevel->subject_code,
                $subalevel->subject_name
            ];
        }
        foreach ($gradeAlevel as $ralevel) {
            $subjectAlevelAGradeArr[] = [
                $ralevel->id,
                $ralevel->grade_code
            ];
        }

        $subjectuec = Subject::where('qualification_type', '4')->get();
        $gradeUec = Grades::where('grade_type','4')->get();
        foreach($subjectuec as $subuec) {
            $subjectUecArr[] = [
                $subuec->subject_code,
                $subuec->subject_name
            ];
        }
        foreach ($gradeUec as $ruec) {
            $subjectUecAGradeArr[] = [
                $ruec->id,
                $ruec->grade_code
            ];
        }


        $subjectSpmStr = json_encode($subjectSpmArr);
        $gradeSpmStr = json_encode($subjectSpmAGradeArr);
        $subjectStamStr = json_encode($subjectStamArr);
        $gradeStamStr = json_encode($subjectStamAGradeArr);
        $subjectUecStr = json_encode($subjectUecArr);
        $gradeUecStr = json_encode($subjectUecAGradeArr);
        $subjectStpmStr = json_encode($subjectStpmArr);
        $gradeStpmStr = json_encode($subjectStpmAGradeArr);
        $subjectAlevelStr = json_encode($subjectAlevelArr);
        $gradeAlevelStr = json_encode($subjectAlevelAGradeArr);
        $subjectOlevelStr = json_encode($subjectOlevelArr);
        $gradeOlevelStr = json_encode($subjectOlevelAGradeArr);

        return view('registration.edit', compact('applicant','country','gender','state','marital','race','religion','qualification', 'subjectspm', 'gradeSpm', 'subjectSpmStr', 'gradeSpmStr', 'subjectstam', 'gradeStam', 'subjectStamStr', 'gradeStamStr', 'subjectuec', 'gradeUec', 'subjectUecStr', 'gradeUecStr', 'subjectstpm', 'gradeStpm', 'subjectStpmStr', 'gradeStpmStr', 'subjectalevel', 'gradeAlevel', 'subjectAlevelStr', 'gradeAlevelStr', 'subjectolevel', 'gradeOlevel', 'subjectOlevelStr', 'gradeOlevelStr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(StoreApplicantDetailRequest $request, $id)
    {
        Applicant::find($id)->update([
            'applicant_name' => $request->applicant_name,
            'applicant_ic' => $request->applicant_ic,
            'applicant_phone' => $request->applicant_phone,
            'applicant_email' => $request->applicant_email,
            'applicant_nationality' => $request->applicant_nationality,
            'applicant_gender' => $request->applicant_gender,
            'applicant_marital' => $request->applicant_marital,
            'applicant_race' => $request->applicant_race,
            'applicant_religion' => $request->applicant_religion,
            'applicant_dob' => $request->applicant_dob,
        ]);

        ApplicantContact::create($request->all());
        ApplicantGuardian::create($request->all());
        ApplicantEmergency::create($request->all());


        $result = [];
        if (isset($request->bachelor_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->bachelor_type,
                'cgpa' => $request->bachelor_cgpa,
            ];

            $academic[] = [
                'applicant_id' => $id,
                'type' => $request->bachelor_type,
                'applicant_study' => $request->bachelor_study,
                'applicant_year' => $request->bachelor_year,
                'applicant_major' => $request->bachelor_major,
            ];
        }

        if (isset($request->diploma_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->diploma_type,
                'cgpa' => $request->diploma_cgpa,
            ];

            $academic[] = [
                'applicant_id' => $id,
                'type' => $request->diploma_type,
                'applicant_study' => $request->diploma_study,
                'applicant_year' => $request->diploma_year,
                'applicant_major' => $request->diploma_major,
            ];
        }

        if (isset($request->muet_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->muet_type,
                'cgpa' => $request->muet_cgpa,
            ];
        }

        if (isset($request->skm_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->skm_type,
                'cgpa' => $request->skm_cgpa,
            ];
        }

        if (isset($request->mqf_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->mqf_type,
                'cgpa' => $request->mqf_cgpa,
            ];
        }

        if (isset($request->kkm_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->kkm_type,
                'cgpa' => $request->kkm_cgpa,
            ];
        }

        if (isset($request->icaew)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->icaew_type,
                'cgpa' => $request->icaew_cgpa,
            ];
        }

        if (isset($request->matriculation_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->matriculation_type,
                'cgpa' => $request->matriculation_cgpa,
            ];

            $academic[] = [
                'applicant_id' => $id,
                'type' => $request->matriculation_type,
                'applicant_study' => $request->matriculation_study,
                'applicant_year' => $request->matriculation_year,
            ];
        }

        if (isset($request->foundation_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->foundation_type,
                'cgpa' => $request->foundation_cgpa,
            ];

            $academic[] = [
                'applicant_id' => $id,
                'type' => $request->foundation_type,
                'applicant_study' => $request->foundation_study,
                'applicant_year' => $request->foundation_year,
                'applicant_major' => $request->foundation_major,
            ];
        }

        if (isset($request->sace_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->sace_type,
                'cgpa' => $request->sace_cgpa,
            ];
        }

        if (isset($request->cat_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->cat_type,
                'cgpa' => $request->cat_cgpa,
            ];
        }

        if (isset($request->spm_subject) && isset($request->spm_grade_id)) {
            if (count($request->spm_subject) > 0 && count($request->spm_grade_id)) {
                for ($i = 0; $i < count($request->spm_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->spm_type,
                        'subject' => $request->spm_subject[$i],
                        'grade_id' => $request->spm_grade_id[$i],
                    ];
                }
            }
        }

        if (isset($request->stam_subject) && isset($request->stam_grade_id)) {
            if (count($request->stam_subject) > 0 && count($request->stam_grade_id)) {
                for ($i = 0; $i < count($request->stam_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->stam_type,
                        'subject' => $request->stam_subject[$i],
                        'grade_id' => $request->stam_grade_id[$i],
                    ];
                }
            }
        }

        if (isset($request->stpm_subject) && isset($request->stpm_grade_id)) {
            if (count($request->stpm_subject) > 0 && count($request->stpm_grade_id)) {
                for ($i = 0; $i < count($request->stpm_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->stpm_type,
                        'subject' => $request->stpm_subject[$i],
                        'grade_id' => $request->stpm_grade_id[$i],
                    ];
                }
            }
        }

        if (isset($request->uec_subject) && isset($request->uec_grade_id)) {
            if (count($request->uec_subject) > 0 && count($request->uec_grade_id)) {
                for ($i = 0; $i < count($request->uec_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->uec_type,
                        'subject' => $request->uec_subject[$i],
                        'grade_id' => $request->uec_grade_id[$i],
                    ];
                }
            }
        }

        if (isset($request->alevel_subject) && isset($request->alevel_grade_id)) {
            if (count($request->alevel_subject) > 0 && count($request->alevel_grade_id)) {
                for ($i = 0; $i < count($request->alevel_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->alevel_type,
                        'subject' => $request->alevel_subject[$i],
                        'grade_id' => $request->alevel_grade_id[$i],
                    ];
                }
            }
        }

        if (isset($request->olevel_subject) && isset($request->olevel_grade_id)) {
            if (count($request->olevel_subject) > 0 && count($request->olevel_grade_id)) {
                for ($i = 0; $i < count($request->olevel_subject); $i++) {
                    $result[] = [
                        'applicant_id' => $id,
                        'type' => $request->olevel_type,
                        'subject' => $request->olevel_subject[$i],
                        'grade_id' => $request->olevel_grade_id[$i],
                    ];
                }
            }
        }
        if (count($result) > 0) {
            foreach ($result as $row) {
                ApplicantResult::create($row);
            }
        }
        if (count($academic) > 0) {
            foreach ($academic as $app_academic) {
                ApplicantAcademic::create($app_academic);
            }
        }

        return redirect()->route('printReg', ['id' => $id]);
    }

    public function printReg($id)
    {
        $applicant = Applicant::where('id',$id)->with(['applicantContactInfo','applicantContactInfo.country','programme','programmeTwo','programmeThree','majorOne','majorTwo','majorThree','country','race','religion','marital'])->get();
        return view('registration.printReg', compact('applicant'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

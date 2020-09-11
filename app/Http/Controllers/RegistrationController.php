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


        $subjectSpmStr = json_encode($subjectSpmArr);
        $gradeSpmStr = json_encode($subjectSpmAGradeArr);
        $subjectStamStr = json_encode($subjectStamArr);
        $gradeStamStr = json_encode($subjectStamAGradeArr);
        return view('registration.edit', compact('applicant','country','gender','state','marital','race','religion','qualification', 'subjectspm', 'gradeSpm', 'subjectSpmStr', 'gradeSpmStr', 'subjectstam', 'gradeStam', 'subjectStamStr', 'gradeStamStr'));
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
        }

        if (isset($request->diploma_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->diploma_type,
                'cgpa' => $request->diploma_cgpa,
            ];
        }

        if (isset($request->muet_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->muet_type,
                'cgpa' => $request->muet_cgpa,
            ];
        }

        if (isset($request->matriculation_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->matriculation_type,
                'cgpa' => $request->matriculation_cgpa,
            ];
        }

        if (isset($request->foundation_cgpa)) {
            $result[] = [
                'applicant_id' => $id,
                'type' => $request->foundation_type,
                'cgpa' => $request->foundation_cgpa,
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
        if (count($result) > 0) {
            foreach ($result as $row) {
                ApplicantResult::create($row);
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

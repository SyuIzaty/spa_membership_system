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
use App\Intakes;
use App\Family;
use App\Grades;
use App\ApplicantResult;
use App\Status;
use App\MajorProgramme;
use App\Files;
use App\AttachmentFile;
use Carbon\Carbon;
use App\Http\Requests\StoreApplicantRequest;
use App\Http\Requests\StoreApplicantDetailRequest;
use File;
use Storage;
use Response;

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
        // $programme = Programme::all()->sortBy('programme_name');
        $programme = Intakes::where('status','1')->with(['intakeDetails.programme','intakeDetails'=>function($query){
            $query->where('status','1');
        }])->first();

        $major = Major::all()->sortBy('major_name');
        $intake = Intakes::where('status','1')->get();
        return view('registration.index', compact('country','programme','major','intake'));
    }

    public function test()
    {
        $test = Intakes::where('status','1')->with(['intakeDetails'=>function($query){
            $query->where('status','1');
        }])->get();
        dd($test);
    }

    public function data($id)
    {
        $all = Programme::find($id);
        $applicant_major = $all->major;
        return response()->json($applicant_major);
    }

    public function getUsers($id)
    {
        $applicant = Applicant::where('applicant_ic', $id)->with(['offeredProgramme','offeredMajor'])->get();
        $userData['data'] = $applicant;
        echo json_encode($userData);
        // $userData[] = $applicant;
        // return response()->json($userData);
    }

    public function register()
    {
        $intake = Intakes::where('status','1')->where('intake_app_open','<=',Carbon::Now())->where('intake_app_close','>=',Carbon::now())->first();
        return view('applicantRegister.index', compact('intake'));
    }

    public function check($id)
    {
        $applicant = Applicant::where('id',$id)->where('applicant_status','5A')->with(['offeredProgramme','offeredMajor','attachmentFile'])->first();

        return view('applicantRegister.check', compact('applicant'));
    }

    public function search(Request $request)
    {
        $intake = Intakes::where('status','1')->where('intake_app_open','<=',Carbon::Now())->where('intake_app_close','>=',Carbon::now())->first();

        $check = Intakes::where('status','1')->where('intake_check_open','<=',Carbon::Now())->where('intake_check_close','>=',Carbon::now())->first();

        $applicant = Applicant::where('applicant_ic',$request->applicant_ic)->where('intake_id',$intake->id)->with('applicantIntake')->get();

        $check_applicant = Applicant::where('applicant_ic',$request->applicant_ic)->where('intake_id',$check->id)->first();

        return view('applicantRegister.display', compact('applicant','intake','check','check_applicant'));
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
        $applicant = Applicant::all();
        $exist = $applicant->filter(function ($value) use ($request){
            return $value['applicant_ic'] === $request->applicant_ic && $value['intake_id'] === $request->intake_id;
        })->count()>0;

        if($exist)
        {
            $applicant_id = Applicant::where('applicant_ic',$request->applicant_ic)->where('intake_id',$request->intake_id)->first();
            Applicant::where('id',$applicant_id->id)->update([
                'applicant_programme'=>$request->applicant_programme,
                'applicant_major'=>$request->applicant_major,
                'applicant_programme_2'=>$request->applicant_programme_2,
                'applicant_major_2'=>$request->applicant_major_2,
                'applicant_programme_3'=>$request->applicant_programme_3,
                'applicant_major_3'=>$request->applicant_major_3,
                ]);
            return $this->edit($applicant_id->id);

        }else{
            $detail = Applicant::create($request->all());

            $applicant_detail = Applicant::where('applicant_ic',$request->applicant_ic)->with(['country','programme','programmeTwo','programmeThree','majorOne','majorTwo','majorThree'])->first();

            Applicant::firstRegistration($applicant_detail['id']);

            return redirect()->route('printRef', ['id' => $request->applicant_ic]);
        }
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
        return view('applicantRegister.display',compact($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::where('id', $id)->with(['applicantContactInfo','applicantEmergency.emergencyOne','applicantGuardian.familyOne','applicantGuardian.familyTwo'])->first();
        $country = Country::all()->sortBy('country_name');
        $gender = Gender::all()->sortBy('gender_name');
        $state = State::all();
        $marital = Marital::all()->sortBy('marital_name');
        $race = Race::all()->sortBy('race_name');
        $religion = Religion::all()->sortBy('religion_name');
        $family = Family::all()->sortBy('family_name');
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

        $existing = ApplicantResult::where('applicant_id',$id)->with('applicant','qualifications')->get();

        $existingcgpa = ApplicantAcademic::where('applicant_id',$id)->with('applicant','qualifications')->get();

        $files = files::where('fkey',$id)->get();
        $groupedfiles = collect($files)->sortByDesc('id')->groupBy('fkey2')->toArray();

        return view('registration.edit', compact('applicant','country','gender','state','marital','race','religion','qualification', 'family', 'subjectspm', 'gradeSpm', 'subjectSpmStr', 'gradeSpmStr', 'subjectstam', 'gradeStam', 'subjectStamStr', 'gradeStamStr', 'subjectuec', 'gradeUec', 'subjectUecStr', 'gradeUecStr', 'subjectstpm', 'gradeStpm', 'subjectStpmStr', 'gradeStpmStr', 'subjectalevel', 'gradeAlevel', 'subjectAlevelStr', 'gradeAlevelStr', 'subjectolevel', 'gradeOlevel', 'subjectOlevelStr', 'gradeOlevelStr','existing','existingcgpa','id','groupedfiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(StoreApplicantDetailRequest $request, $id, $type = null)
    {
        $applicant = Applicant::find($id)->update([
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
            'applicant_status' => '00',
            'applicant_qualification' => $request->highest_qualification,
        ]);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $applicant->addMediaFromRequest('image')->toMediaCollection('images');
        }

        ApplicantContact::updateOrCreate([
            'applicant_id' => $id,
        ],[
            'applicant_address_1' => $request->applicant_address_1,
            'applicant_address_2' => $request->applicant_address_2,
            'applicant_poscode' => $request->applicant_poscode,
            'applicant_city' => $request->applicant_city,
            'applicant_state' => $request->applicant_state,
            'applicant_country' => $request->applicant_country
        ]);

        ApplicantGuardian::updateOrCreate([
            'applicant_id' => $id,
        ],[
            'guardian_one_name' => $request->guardian_one_name,
            'guardian_one_relationship' => $request->guardian_one_relationship,
            'guardian_one_mobile' => $request->guardian_one_mobile,
            'guardian_one_address' => $request->guardian_one_address,
            'guardian_two_name' => $request->guardian_two_name,
            'guardian_two_relationship' => $request->guardian_two_relationship,
            'guardian_two_mobile' => $request->guardian_two_mobile,
            'guardian_two_address' => $request->guardian_two_address,
        ]);

        ApplicantEmergency::updateOrCreate([
            'applicant_id' => $id,
        ],[
            'emergency_name' => $request->emergency_name,
            'emergency_relationship' => $request->emergency_relationship,
            'emergency_phone' => $request->emergency_phone,
            'emergency_address' => $request->emergency_address
        ]);


        $result = [];
        if (isset($request->bachelor_cgpa)) {
            $academic[] = [
                'id' => $request->exist_bachelor,
                'applicant_id' => $id,
                'type' => $request->bachelor_type,
                'applicant_study' => $request->bachelor_study,
                'applicant_year' => $request->bachelor_year,
                'applicant_major' => $request->bachelor_major,
                'applicant_cgpa' => $request->bachelor_cgpa,
            ];
        }

        if (isset($request->diploma_cgpa)) {

            $academic[] = [
                'id' => $request->exist_diploma,
                'applicant_id' => $id,
                'type' => $request->diploma_type,
                'applicant_study' => $request->diploma_study,
                'applicant_year' => $request->diploma_year,
                'applicant_major' => $request->diploma_major,
                'applicant_cgpa' => $request->diploma_cgpa,
            ];
        }

        if (isset($request->muet_cgpa)) {
            $academic[] = [
                'id' => $request->exist_muet,
                'applicant_id' => $id,
                'type' => $request->muet_type,
                'applicant_cgpa' => $request->muet_cgpa,
            ];
        }

        if (isset($request->skm_cgpa)) {
            $academic[] = [
                'id' => $request->exist_skm,
                'applicant_id' => $id,
                'type' => $request->skm_type,
                'applicant_cgpa' => $request->skm_cgpa,
            ];
        }

        if (isset($request->mqf_cgpa)) {
            $academic[] = [
                'id' => $request->exist_mqf,
                'applicant_id' => $id,
                'type' => $request->mqf_type,
                'applicant_cgpa' => $request->mqf_cgpa,
            ];
        }

        if (isset($request->kkm_cgpa)) {
            $academic[] = [
                'id' => $request->exist_kkm,
                'applicant_id' => $id,
                'type' => $request->kkm_type,
                'applicant_cgpa' => $request->kkm_cgpa,
            ];
        }

        if (isset($request->icaew)) {
            $academic[] = [
                'id' => $request->exist_icaew,
                'applicant_id' => $id,
                'type' => $request->icaew_type,
                'applicant_cgpa' => $request->icaew_cgpa,
            ];
        }

        if (isset($request->matriculation_cgpa)) {
            $academic[] = [
                'id' => $request->exist_matriculation,
                'applicant_id' => $id,
                'type' => $request->matriculation_type,
                'applicant_study' => $request->matriculation_study,
                'applicant_year' => $request->matriculation_year,
                'applicant_cgpa' => $request->matriculation_cgpa,
            ];
        }

        if (isset($request->foundation_cgpa)) {

            $academic[] = [
                'id' => $request->exist_foundation,
                'applicant_id' => $id,
                'type' => $request->foundation_type,
                'applicant_study' => $request->foundation_study,
                'applicant_year' => $request->foundation_year,
                'applicant_major' => $request->foundation_major,
                'applicant_cgpa' => $request->foundation_cgpa,
            ];
        }

        if (isset($request->sace_cgpa)) {
            $academic[] = [
                'id' => $request->exist_sace,
                'applicant_id' => $id,
                'type' => $request->sace_type,
                'applicant_cgpa' => $request->sace_cgpa,
            ];
        }

        if (isset($request->cat_cgpa)) {
            $academic[] = [
                'id' => $request->exist_cat,
                'applicant_id' => $id,
                'type' => $request->cat_type,
                'applicant_cgpa' => $request->cat_cgpa,
            ];
        }

        if (isset($request->spm_subject) && isset($request->spm_grade_id)) {
            if (count($request->spm_subject) > 0 && count($request->spm_grade_id)) {
                for ($i = 0; $i < count($request->spm_subject); $i++) {
                    $result[] = [
                        'id' => $request->exist_spm[$i],
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
                        'id' => $request->exist_stam[$i],
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
                        'id' => $request->exist_stpm[$i],
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
                        'id' => $request->exist_uec[$i],
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
                        'id' => $request->exist_alevel[$i],
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
                        'id' => $request->exist_olevel[$i],
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
                if( isset($row['id']) && $row['id'] )
                {
                    $appid = $row['id'];
                    ApplicantResult::where('id',$row['id'])->update($row);
                }
                else
                {
                    $app = ApplicantResult::create($row);
                    $appid = $app->id;
                }
                Applicant::where('id',$row['applicant_id'])->update(['applicant_status' => '0']);
            }
        }

        if (isset($academic)) {
            foreach ($academic as $arow) {
                if( isset($arow['id']) && $arow['id'] )
                {
                    ApplicantAcademic::where('id',$arow['id'])->update($arow);
                }
                else
                {
                    ApplicantAcademic::create($arow);
                }
                Applicant::where('id',$arow['applicant_id'])->update(['applicant_status' => '0']);
            }
        }

        if($request->hasFile('file'))
        {
            foreach($request->file as $key => $value)
            {
                $this->uploadFile($request->file[$key],$request->filetype[$key],$id);
            }
        }

        if($type){
            return 1;
        }

        Applicant::completeApplication($id);

        return redirect()->route('printReg', ['id' => $id]);
    }

    public function qualificationfile($filename,$type)
    {
        $path = storage_path().'/'.'app'.'/qualification/'.$filename;

        if($type == "Download")
        {
            if (file_exists($path)) {
                return Response::download($path);
            }
        }
        else
        {
            $file = File::get($path);
            $filetype = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }

    }

    public function attachmentFile($filename,$type)
    {
        $path = storage_path().'/'.'app'.'/batch/'.$filename;

        if($type == "Download")
        {
            if (file_exists($path)) {
                return Response::download($path);
            }
        }
    }

    public function uploadFile($file,$qualificationid,$userid)
    {
        $this->deleteStorage($qualificationid,$userid);

        $type="Qualification";
        $path=storage_path()."/qualification/";
        $extension = $file->getClientOriginalExtension();
        $originalName=$file->getClientOriginalName();
        $fileSize=$file->getSize();
        $fileName= $originalName;
        $file->storeAs('/qualification', $fileName);
        files::create(
            [
             'type' => $type,
             'fkey' => $userid,
             'fkey2' => $qualificationid,
             'file_name' => $originalName,
             'file_size' => $fileSize,
             'web_path' => "app/qualification/".$fileName,
             'created_at' => date("Y-m-d H:i:s"),
             'updated_at' => date("Y-m-d H:i:s")
            ]
        );
    }

    public function deleteStorage($id,$userid)
    {
        $myfile =  files::where('fkey',$userid)->where('fkey2',$id)->select('web_path')->first();
        if($myfile)
        {
            $path = storage_path().'/'.$myfile->web_path;
            unlink($path);
            files::where('fkey',$userid)->where('fkey2',$id)->delete();
        }
    }

    public function deleteitem($id,$type,$userid)
    {
        $destinationPath =  files::where('fkey',$userid)->where('fkey2',$id)->select('web_path')->get();
        foreach($destinationPath as $dp)
        {
            File::delete(storage_path()."/".$dp->web_path);
        }
        files::where('fkey',$userid)->where('fkey2',$id)->delete();

        if($type == "result"){
            ApplicantResult::where('id',$id)->delete();
        }

        if($type == "qualification")
        {
            ApplicantResult::where('type',$id)->where('applicant_id',$userid)->delete();
        }

        if($type == "academic")
        {
            ApplicantAcademic::where('type',$id)->where('applicant_id',$userid)->delete();
        }


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

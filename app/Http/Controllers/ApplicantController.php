<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\ApplicantResult;
use App\ApplicantStatus;
use App\ApplicantContact;
use App\ApplicantAcademic;
use App\Grades;
use App\Programme;
use App\Country;
use App\Religion;
use App\Marital;
use App\Gender;
use App\Race;
use App\State;
use App\Qualification;
use App\Subject;
use App\ApplicantEmergency;
use App\ApplicantGuardian;
use App\IntakeDetail;
use App\Intakes;
use DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade as PDF;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Applicant $applicant)
    {

        //$applicant=Applicant::latest()->get();
        //$programme = DB::select('select * from programmes');
        $programme = DB::table('programmes')
        ->select('*')
        ->where('id', $applicant->applicant_programme)
        ->get();
        foreach ($programme as $program)

        // return view ('applicant.index',compact('applicant','programme','program'));
        return view ('applicant.showapp',compact('applicant','program'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $programme = DB::select('select * from programmes');
        return view('applicant.create',['programme'=>$programme]);
    }

    public function createcontact(Applicant $applicant, ApplicantContact $applicantcontact)
    {


        return view('applicant.contact',compact('applicant','applicantcontact'));
    }

    public function createacademic(Applicant $applicant, ApplicantAcademic $applicantacademic)
    {

        $qualifications = DB::select('select * from qualifications');
        $subject = DB::select('select * from subjects');
        $grades = DB::select('select * from grades');
        return view('applicant.createacademic',['qualifications'=>$qualifications,'subject'=>$subject,'grades'=>$grades],compact('applicant','applicantacademic','qualifications','subject','grades'));
    }



      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($applicant);
        // Validate posted form data
        $validated = $request->validate([
        'applicant_name' => 'required|string|min:|max:100',
        'applicant_ic' => 'required|string|min:|max:100',
        'applicant_email' => 'required|string|min:|max:100',
        'applicant_phone' => 'required|string|min:|max:100',
        'applicant_programme' => 'required|string|min:|max:100',
        'applicant_programme_2' => 'required|string|min:|max:100',
        'applicant_programme_3' => 'required|string|min:|max:100',
        'applicant_nationality' => 'required|string|min:|max:100',
        'applicant_gender' => 'string|min:|max:100',
        'applicant_religion' => 'string|min:|max:100',

    ]);

    // Create and save applicant with validated data


    $applicant = Applicant::create($validated);
    // dd($applicant);
    $programme = DB::table('programmes')
    ->select('*')
    ->where('id', $applicant->applicant_programme)
    ->get();
 //dd($programme);
     foreach ($programme as $program)

    // Redirect the user to the created applicant with a success notification
    return redirect(route('applicant.profile',$applicant,$programme))->with('notification', 'Applicant created!');

    }



    public function storeacademic(Request $request, Applicant $applicant, ApplicantAcademic $academic, Qualification $qualification, Subject $subject, ApplicantResult $applicantresult, Grades $grades)
    {

        $data = [
            'applicant_id' => $request->id,
            'type' => $request->qualification_type,
        ];

        $academic=ApplicantAcademic::create($data);
        //$subject = DB::table('subjects');
        //$subjectcode =Subject::select('subjects')->where('subject_code')->latest()->get();
        // $subjectcode = DB::table('subjects')
        // ->select('*')
        // ->where('subject_code')
        // ->get();
        $subject = Subject::all('subject_code');
        // $subjectcode= DB::table('applicant_contact_info')->latest()->get();
        //dd($subject);
        $dataresult = [
            'applicant_id' => $request->id,
            'type' => $request->qualification_type,
            'subject'=>$request->subject_code,
            'grade_id'=>$request->id,
        ];

        $result=ApplicantResult::create($dataresult);
        dd($result);

        //dd($data);
        $qualification = DB::table('qualifications')
        ->select('*')
        ->where('id', $academic->type)
        ->get();
        //dd($qualification);

        $subject = DB::select('select * from subjects');
        $grades = DB::select('select * from grades');

        foreach ($subject as $subjects)
        foreach ($qualification as $qualifications)
        foreach ($grades as $grade)

        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('applicantresult')
          ->where($select, $value)
          ->groupBy($dependent)
          ->get();
          dd($data);
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;


        //dd($data);
        return redirect(route('applicant.academicinfo',$applicant,$academic,$qualification,$qualifications,$subjects,$subject,$grades,$grade))->with('notification', 'Qualifications created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Applicant  $applicant

     * @return \Illuminate\Http\Response
     */
    public function showapp(Applicant $applicant )
    {

        //dd($applicant);

        $programme = DB::table('programmes')
        ->select('*')
        ->where('id', $applicant->applicant_programme)
        ->get();

         foreach ($programme as $program)

        return view ('applicant.showapp',compact('applicant','programme','program'));
    }
    public function profile(Applicant $applicant)
    {


    return view ('applicant.profile',compact('applicant'));
    }



    public function academicinfo(Applicant $applicant,ApplicantAcademic $applicantacademic, Qualification $qualification)
    {
        $qualification= DB::table('qualifications')->latest()->get();
       // ApplicantAcademic::where('qualification_type',$qualification);
        //dd($qualification);
        // $qualification = DB::table('qualifications')
        // ->select('*')
        // ->where('id', $applicantacademic->qualification_type)
        // ->latest()
        // ->get();


        foreach ($qualification as $qualifications)
        return view ('applicant.academic',compact('applicant','applicantacademic','qualification','qualifications'));
    }



    public function prefprogramme(Applicant $applicant,Programme $programme)
    {

        $programme = DB::table('programmes')
        ->select('*')
        ->where('id', $applicant->applicant_programme)
        ->get();
        //$programme = DB::select('select * from programmes');

         foreach ($programme as $program )

        return view ('applicant.program',compact('applicant','programme','program'));
        //return view ('applicant.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function edit( Applicant $applicant, Programme $programme)
    {


        //$programme = DB::select('select * from programmes');
        $programme = DB::table('programmes')
       ->select('*')
       ->where('id', $applicant->applicant_programme)
       ->get();
        foreach ($programme as $program)
        //return view('applicant.create',['programme'=>$programme]);
        return view ('applicant.edit',compact('applicant','programme','program'));
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Applicant $applicant, Programme $programme)
    {
        // Validate posted form data
        $validated = $request->validate([
            'applicant_name' => 'string|min:|max:100',
            'applicant_ic' => 'string|min:|max:100',
            'applicant_email' => 'string|min:|max:100',
            'applicant_phone' => 'string|min:|max:100',
            'applicant_nationality' => 'string|min:|max:100',
            'applicant_gender' => 'string|min:|max:100',
            'applicant_religion' => 'string|min:|max:100',

        ]);

        // Create and save post with validated data
        $applicant->update($validated);
        //dd($validated);

        // Redirect the user to the created post with a success notification
        return redirect(route('applicant.profile',$applicant))->with('notification', 'Applicant Updated!');

    }

    public function storecontact(Request $request, Applicant $applicant)
    {

        $data = [
            'applicant_id' => $request->id,
            'applicant_address_1' => $request->applicant_address_1,
            'applicant_address_2' => $request->applicant_address_2,
            'applicant_poscode' => $request->applicant_poscode,
            'applicant_city' => $request->applicant_city,
            'applicant_state' => $request->applicant_state,
            'applicant_country' => $request->applicant_country,
            'applicant_phone_office' => $request->applicant_phone_office,
            'applicant_phone_home' => $request->applicant_phone_home,
            'applicant_phone_mobile' => $request->applicant_phone_mobile,
            'applicant_email' => $request->applicant_email,
        ];

        $applicantcontact=ApplicantContact::create($data);

        //dd($data);
        return redirect(route('applicant.contactinfo',$applicant,$applicantcontact))->with('notification', 'Contact created!');
    }



    public function contactinfo(Applicant $applicant,ApplicantContact $applicantcontact)
    {


        $appcontact= DB::table('applicant_contact_info')->latest()->get();
        //dd($appcontact);
        foreach ($appcontact as $appcontact1)
        return view ('applicant.contactview',compact('applicant','applicantcontact','appcontact','appcontact1'));
    }

    public function updatecontact(Request $request, Applicant $applicant, ApplicantContact $applicantcontact)
    {
        // Validate posted form data
        $validated = $request->validate([
            'applicant_address_1' => 'string|min:|max:100',
            'applicant_address_2' => 'string|min:|max:100',
            'applicant_poscode' => 'string|min:|max:100',
            'applicant_city' => 'string|min:|max:100',
            'applicant_state' => 'string|min:|max:100',
            'applicant_country' => 'string|min:|max:100',
            'applicant_phone_office' => 'string|min:|max:100',
            'applicant_phone_home' => 'string|min:|max:100',
            'applicant_phone_mobile' => 'string|min:|max:100',
            'applicant_email' => 'string|min:|max:100',

        ]);



        // Create and save post with validated data
         $applicantcontact->update($validated);
         dd($validated);

     //return view ('applicant.contact',compact('applicant','applicantcontact'))->with('notification', 'Contact Updated!');
     return redirect(route('applicant.contactinfo',$applicantcontact))->with('notification', 'Contact updated!');
    }


    public function updateprogramme(Request $request, Applicant $applicant, Programme $programme)
    {
        // Validate posted form data
        $validated = $request->validate([
            'applicant_programme' => 'string|min:|max:100',
            'applicant_programme_2' => 'string|min:|max:100',
            'applicant_programme_3' => 'string|min:|max:100',
        ]);

        // Create and save post with validated data
        $applicant->update($validated);
        $programme = DB::table('programmes')
       ->select('*')
       ->where('id', $applicant->applicant_programme)
       ->get();

        foreach ($programme as $program)

        // Redirect the user to the created post with a success notification
        return redirect(route('applicant.prefprogramme',$applicant))->with('notification', 'Programme Updated!');
        //return view ('applicant.program',compact('applicant','programme','program'))->with('notification', 'Applicant Updated!');

    }
    public function updateacademic(Request $request, Applicant $applicant,ApplicantAcademic $applicantacademic, Qualification $qualification)
    {
        // Validate posted form data
        $validated = $request->validate([
            'type' => 'string|min:|max:100',
        ]);

        // Create and save post with validated data
        $applicantacademic->update($validated);
        $qualification = DB::table('qualifications')
       ->select('*')
       ->where('id', $applicantacademic->type)
       ->get();

        foreach ($qualification as $qualifications)

        // Redirect the user to the created post with a success notification
        return redirect(route('applicant.academic',$applicant))->with('notification', 'Programme Updated!');
        //return view ('applicant.program',compact('applicant','programme','program'))->with('notification', 'Applicant Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        //
        $applicant->delete();
    }

    public function show($id)
    {
        $applicant = Applicant::where('id',$id)->with(['applicantContactInfo','applicantGuardian','applicantEmergency','applicantIntake','status'])->first();
        $applicantresult = ApplicantResult::where('applicant_id',$id)->get();
        $applicantAcademic = ApplicantAcademic::where('applicant_id',$id)->get();

        $applicants = Applicant::where('id',$id)->get()->toArray();
        $country = Country::all();
        $marital = Marital::all();
        $religion = Religion::all();
        $race = Race::all();
        $gender = Gender::all();
        $state = State::all();

        foreach ($applicants as $key => $applicantt)
        {
            $total_point = 0;

            $pro = explode(',',$applicant['applicant_programme']);
            $sta = explode(',',$applicant['programme_status']);
            $programmestatus = [];
            for($i=0; $i < count($pro); $i++)
            {
                $prog = Programme::where('id',$pro[$i])->first();
                $programmestatus[$i]['id'] = $prog->id;
                $programmestatus[$i]['programme'] = $prog->programme_name;
                $programmestatus[$i]['status'] = $sta[$i];
            }
        }
            $spm = ApplicantResult::where('applicant_id',$id)->where('type','1')
            ->with(['grades','subjects','applicantAcademic'=>function($query){
                $query->where('type','1');
            }])->get();

            $stpm_result = ApplicantResult::where('applicant_id',$id)->where('type',2)->get();
            $stpm = $stpm_result->load('grades','subjects');

            $stam_result = ApplicantResult::where('applicant_id',$id)->where('type',3)->get();
            $stam = $stam_result->load('grades','subjects');

            $uec_result = ApplicantResult::where('applicant_id',$id)->where('type',4)->get();
            $uec = $uec_result->load('grades','subjects');

            $alevel_result = ApplicantResult::where('applicant_id',$id)->where('type',5)->get();
            $alevel = $alevel_result->load('grades','subjects');

            $olevel_result = ApplicantResult::where('applicant_id',$id)->where('type',6)->get();
            $olevel = $olevel_result->load('grades','subjects');

            $diploma = ApplicantResult::where('applicant_id',$id)->where('type','8')
            ->with(['applicantAcademic'=>function($query){
                $query->where('type','8');
            }])->first();

            $degree = ApplicantResult::where('applicant_id',$id)->where('type','9')
            ->with(['applicantAcademic'=>function($query){
                $query->where('type','9');
            }])->first();

            $skm = ApplicantResult::where('applicant_id',$id)->where('type','7')->first();

            $sace = ApplicantResult::where('applicant_id',$id)->where('type','10')->first();

            $muet = ApplicantResult::where('applicant_id',$id)->where('type','11')->first();

            $mqf = ApplicantResult::where('applicant_id',$id)->where('type','14')->first();

            $kkm = ApplicantResult::where('applicant_id',$id)->where('type','15')->first();

            $cat = ApplicantResult::where('applicant_id',$id)->where('type','16')->first();

            $icaew = ApplicantResult::where('applicant_id',$id)->where('type','17')->first();

            $matriculation = ApplicantResult::where('applicant_id',$id)->where('type','12')
            ->with(['applicantAcademic'=>function($query){
                $query->where('type','12');
            }])->first();

            $applicant2 = Applicant::where('id',$id)->get()->toArray();
            foreach($applicant2 as $applicantstat)
            {
                $programme_1['programme_1'] = Programme::where('id',$applicantstat['applicant_programme'])->get();
                $programme_2['programme_2'] = Programme::where('id',$applicantstat['applicant_programme_2'])->get();
                $programme_3['programme_3'] = Programme::where('id',$applicantstat['applicant_programme_3'])->get();

                $dataappl[] = array_merge($applicantstat, $programme_1, $programme_2, $programme_3);
            }

            $aapplicant = $dataappl;
            $activity = [];
            $applicant_status = ApplicantStatus::where('applicant_id',$id)->get();
            foreach($applicant_status as $app_stat)
            {
                $activity = Activity::where('properties->attributes->applicant_id', $app_stat['applicant_id'])->get();
            }

            $intake = Intakes::all();

        return view('applicant.display',compact('applicant','spm','stpm','stam','uec','alevel','olevel','diploma','degree','matriculation','muet','sace','applicantresult','total_point', 'programmestatus', 'aapplicant','country','marital','religion','race','gender','state','skm','mqf','kkm','cat','icaew','activity','intake'));
    }

    public function updateApplicant(Request $request)
    {
        Applicant::where('id', $request->id)->update([
            'applicant_name' => $request->applicant_name,
            'applicant_ic' => $request->applicant_ic,
            'applicant_dob' => $request->applicant_dob,
            'applicant_phone' => $request->applicant_phone,
            'applicant_email' => $request->applicant_email,
            'applicant_gender' => $request->applicant_gender,
            'applicant_marital' => $request->applicant_marital,
            'applicant_race' => $request->applicant_race,
            'applicant_religion' => $request->applicant_religion,
            'applicant_nationality' => $request->applicant_nationality
        ]);
        ApplicantContact::where('applicant_id', $request->id)->update([
            'applicant_address_1' => $request->applicant_address_1,
            'applicant_address_2' => $request->applicant_address_2,
            'applicant_poscode' => $request->applicant_poscode,
            'applicant_city' => $request->applicant_city,
            'applicant_state' => $request->applicant_state,
            'applicant_country' => $request->applicant_country,
        ]);

        return redirect()->back();
    }

    public function updateEmergency(Request $request)
    {
        $this->validate($request, [
            'emergency_name' => 'required',
            'emergency_phone' => 'required',
            'emergency_address' => 'required',
            'emergency_relationship' => 'required',
        ]);

        ApplicantEmergency::where('applicant_id',$request->id)->update($request->except(['_token']));
        return redirect()->back();
    }

    public function updateGuardian(Request $request)
    {
        ApplicantGuardian::where('applicant_id',$request->id)->update($request->except(['_token']));
        return redirect()->back();
    }

    public function indexs()
    {
        return view('applicant.applicantresult');
    }

    public function testCollection()
    {
        // $applicant = Applicantstatus::where('applicant_status','5')->get();
        // $applicants = $applicant->load('applicant','programme','major','applicantresult','applicantresult.grades','applicant.applicantIntake','statusResult');
        // foreach($applicants as $app){
        //     dd($app->applicant->statusResult->colour);
        // }
    }

    public function data_allapplicant()
    {
        $applicant = Applicant::where('applicant_status',NULL)->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','statusResultThree','programmeThree','applicantstatus','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return isset($applicants->intake_code) ? $applicants->intake_code : '';
            })
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->statusResult->colour.'">'.$applicants->programme->programme_code.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                // return '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>';
                return isset($applicants->programmeTwo->programme_code) ? '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>' : '';

            })
            ->addColumn('prog_name_3',function($applicants)
            {
                // return isset($applicants->programmeThree->programme_code) ? $applicants->programmeThree->programme_code.$applicants->programme_status_3 : '';
                return isset($applicants->programmeThree->programme_code) ? '<div style="color:'.$applicants->statusResultThree->colour.'">'.$applicants->programmeThree->programme_code.'</div>' : '';

            })
            ->addColumn('bm',function($applicants){
                return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            })
            ->addColumn('english',function($applicants){
                return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            })
            ->addColumn('math',function($applicants){
                return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            })

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_passapplicant()
    {
        $applicant = Applicant::where('programme_status','1')->orWhere('programme_status_2','1')->orWhere('programme_status_3','1')->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','statusResultThree','programmeThree','applicantstatus','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return isset($applicants->intake_code) ? $applicants->intake_code : '';
            })
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->statusResult->colour.'">'.$applicants->programme->programme_code.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                // return '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>';
                return isset($applicants->programmeTwo->programme_code) ? '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>' : '';

            })
            ->addColumn('prog_name_3',function($applicants)
            {
                // return isset($applicants->programmeThree->programme_code) ? $applicants->programmeThree->programme_code.$applicants->programme_status_3 : '';
                return isset($applicants->programmeThree->programme_code) ? '<div style="color:'.$applicants->statusResultThree->colour.'">'.$applicants->programmeThree->programme_code.'</div>' : '';

            })
            ->addColumn('bm',function($applicants){
                return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            })
            ->addColumn('english',function($applicants){
                return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            })
            ->addColumn('math',function($applicants){
                return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            })

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_rejectedapplicant()
    {
        // $applicant = Applicant::where('applicant_status',NULL)->get();
        $applicant = Applicant::where('programme_status','2')->where('programme_status_2','2')->orWhere('programme_status_2',NULL)->where('programme_status_3','2')->orWhere('programme_status_3',NULL)->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','applicantstatus','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return isset($applicants->intake_code) ? $applicants->intake_code : '';
            })
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->statusResult->colour.'">'.$applicants->programme->programme_code.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                // return '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>';
                return isset($applicants->programmeTwo->programme_code) ? '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programmeTwo->programme_code.'</div>' : '';

            })
            ->addColumn('prog_name_3',function($applicants)
            {
                // return isset($applicants->programmeThree->programme_code) ? $applicants->programmeThree->programme_code.$applicants->programme_status_3 : '';
                return isset($applicants->programmeThree->programme_code) ? '<div style="color:'.$applicants->statusResultThree->colour.'">'.$applicants->programmeThree->programme_code.'</div>' : '';

            })
            ->addColumn('bm',function($applicants){
                return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            })
            ->addColumn('english',function($applicants){
                return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            })
            ->addColumn('math',function($applicants){
                return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            })

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Detail</a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_offerapplicant()
    {
        $applicant = Applicantstatus::where('applicant_status','3')->get();
        $applicants = $applicant->load('applicant','programme','major','applicantresult','applicantresult.grades','applicant.applicantIntake');
        return datatables()::of($applicants)
            ->addColumn('applicant_name',function($applicants)
            {
                return $applicants->applicant->applicant_name;
            })
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicant->applicantIntake->intake_code;
            })
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->applicant->statusResult->colour.'">'.$applicants->applicant->applicant_programme.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                return isset($applicants->applicant->applicant_programme_2) ? '<div style="color:'.$applicants->applicant->statusResultTwo->colour.'">'.$applicants->applicant->applicant_programme_2.'</div>' : '';

            })
            ->addColumn('prog_name_3',function($applicants)
            {
                return isset($applicants->applicant->applicant_programme_2) ? '<div style="color:'.$applicants->applicant->statusResultThree->colour.'">'.$applicants->applicant->applicant_programme_3.'</div>' : '';
            })
            ->addColumn('bm',function($applicants){
                return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            })
            ->addColumn('english',function($applicants){
                return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            })
            ->addColumn('math',function($applicants){
                return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            })

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->applicant->id.'" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Detail</a>
               <a href="'.action('IntakeController@letter', ['applicant_id' => $applicants->applicant->id]).'" class="btn btn-sm btn-info">Offer Letter</a>
               <a href="'.action('IntakeController@sendEmail', ['applicant_id' => $applicants->applicant->id, 'intake_id' => $applicants->applicant->intake_id]).'" class="btn btn-sm btn-primary">Send Email</a>
               ';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_acceptedapplicant()
    {
        $applicant = Applicantstatus::where('applicant_status','5')->get();
        $applicants = $applicant->load('applicant','programme','major','applicantresult','applicantresult.grades','applicant.applicantIntake');
        return datatables()::of($applicants)
            ->addColumn('applicant_name',function($applicants)
            {
                return isset($applicants->intake_code) ? $applicants->intake_code : '';
            })
            ->addColumn('applicant_name',function($applicants)
            {
                return $applicants->applicant->applicant_name;
            })
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicant->applicantIntake->intake_code;
            })
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->applicant->statusResult->colour.'">'.$applicants->applicant->applicant_programme.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                return isset($applicants->applicant->applicant_programme_2) ? '<div style="color:'.$applicants->applicant->statusResultTwo->colour.'">'.$applicants->applicant->applicant_programme_2.'</div>' : '';

            })
            ->addColumn('prog_name_3',function($applicants)
            {
                return isset($applicants->applicant->applicant_programme_2) ? '<div style="color:'.$applicants->applicant->statusResultThree->colour.'">'.$applicants->applicant->applicant_programme_3.'</div>' : '';
            })
            ->addColumn('bm',function($applicants){
                return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            })
            ->addColumn('english',function($applicants){
                return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            })
            ->addColumn('math',function($applicants){
                return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            })

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->applicant->id.'" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Detail</a>
               ';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function accepted($applicantt, $programme_code)
    {
        $applicants = Applicant::where('id',$applicantt['id'])->get();
        if($applicantt['applicant_programme'] == $programme_code){
            $programme_status = $applicants->where('applicant_programme',$programme_code)->first();
            $programme_status->programme_status = '1';
            $programme_status->save();

        }
        if($applicantt['applicant_programme_2'] == $programme_code){
            $programme_status_2 = $applicants->where('applicant_programme_2',$programme_code)->first();
            $programme_status_2->programme_status_2 = '1';
            $programme_status_2->save();

        }
        if($applicantt['applicant_programme_3'] == $programme_code){
            $programme_status_3 = $applicants->where('applicant_programme_3',$programme_code)->first();
            $programme_status_3->programme_status_3 = '1';
            $programme_status_3->save();
        }
        Applicant::where('id',$applicantt['id'])->where('applicant_status',NULL)->update(['applicant_status'=>'2']);
    }

    public function rejected($applicantt, $programme_code)
    {
        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status = '2';
            $programme_status->save();
        }

        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_2',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status_2 = '2';
            $programme_status->save();
        }

        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_3',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status_3 = '2';
            $programme_status->save();
        }

        Applicant::where('id',$applicantt['id'])->where('applicant_status',NULL)->update(['applicant_status'=>'2']);
    }

    public function spm($applicantt)
    {
        $app_spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->where('grade_id','<=',8)->get();
        $spm = $app_spm->count();
        $count_eng = $app_spm->where('subject',1119)->count();
        $count_math = $app_spm->where('subject',1449)->count();

        return compact('applicantt', 'app_spm', 'spm', 'count_eng', 'count_math');
    }

    public function stpm($applicantt)
    {
        $app_stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->where('grade_id','<=',17)->get();
        $stpm = $app_stpm->count();

        $count_math_m = $app_stpm->where('subject',950)->count();
        $count_math_t = $app_stpm->where('subject',954)->count();
        $count_eng = $app_stpm->where('subject',920)->count();
        return compact('app_stpm', 'stpm', 'count_math_m', 'count_math_t', 'count_eng');
    }

    public function stam($applicantt)
    {
        $app_stam = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',3)->where('grade_id','<=',15)->get();
        $stam = $app_stam->count();

        return compact('app_stam', 'stam');
    }

    public function uec($applicantt)
    {
        $app_uec = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',4)->where('grade_id','<=',25)->get();
        $uec = $app_uec->count();
        $count_math = $app_uec->where('subject','UEC104')->count();
        return compact('app_uec', 'uec', 'count_math');
    }

    public function olevel($applicantt)
    {
        $app_olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->where('grade_id','<=',45)->get();
        $olevel = $app_olevel->count();
        $count_eng = $app_olevel->where('subject','CIE1119')->count();
        $count_math_a = $app_olevel->where('subject','CIE4937')->count();
        $count_math_d = $app_olevel->where('subject','CIE4024')->count();
        return compact('applicantt', 'app_olevel', 'olevel', 'count_eng', 'count_math_a', 'count_math_d');
    }

    public function mqf($applicantt)
    {
        $mqf = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->where('cgpa','>=',2.00)->count();
        return compact('mqf');
    }

    public function skm($applicantt)
    {
        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->count();
        return compact('skm');
    }

    public function kkm($applicantt)
    {
        $kkm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',15)->where('cgpa','>=',2.00)->count();
        return compact ('kkm');
    }

    public function iat12($applicantt) //American Degree Transfer Programme
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $spm['spm'] >= 5)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['count_eng'] == 1  && ($olevel['count_math_a'] == 1 || $olevel['count_math_d'] == 1) && $olevel['olevel'] >= 5)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $status = array($status_spm, $status_olevel);

        if(in_array(true, $status))
        {
            $programme_code = 'IAT12';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IAT12';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ial10($applicantt) //A Level Programme
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $spm['spm'] >= 5)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['count_eng'] == 1  && ($olevel['count_math_a'] == 1 || $olevel['count_math_d'] == 1) && $olevel['olevel'] >= 5)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $status = array($status_spm, $status_olevel);

        if(in_array(true, $status))
        {
            $programme_code = 'IAL10';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IAL10';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function igr22($applicantt) //A Level German Programme
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $spm['spm'] >= 5)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['count_eng'] == 1  && ($olevel['count_math_a'] == 1 || $olevel['count_math_d'] == 1) && $olevel['olevel'] >= 5)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $status = array($status_spm, $status_olevel);

        if(in_array(true, $status))
        {
            $programme_code = 'IGR22';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IGR22';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function iam10($applicantt) //SACE International
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $spm['spm'] >= 5)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['count_eng'] == 1  && ($olevel['count_math_a'] == 1 || $olevel['count_math_d'] == 1) && $olevel['olevel'] >= 5)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $status = array($status_spm, $status_olevel);

        if(in_array(true, $status))
        {
            $programme_code = 'IAM10';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IAM10';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ile12($applicantt) //Japanese Preparatory Course
    {
        $status = [];
        $app_spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->where('grade_id','<=',8)->get();
        $spm = $app_spm->count();

        $count_math = $app_spm->where('subject',1449)->count();
        $count_bio = $app_spm->where('subject',4551)->count();
        $count_chem = $app_spm->where('subject',4541)->count();
        $count_phy = $app_spm->where('subject',4531)->count();
        $count_sci = $app_spm->where('subject',1511)->count();
        if(($count_math == 1 && ($count_bio == 1 || $count_chem == 1 || $count_phy == 1 || $count_sci == 1)) || ($count_math == 1) && $spm >= 5)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $olevel = $this->olevel($applicantt);

        $count_bio = $olevel['app_olevel']->where('subject','CIE5090')->count();
        $count_chemistry = $olevel['app_olevel']->where('subject','CIE5070')->count();
        $count_phy = $olevel['app_olevel']->where('subject','CIE5054')->count();
        $count_science = $olevel['app_olevel']->where('subject','CIE5129')->count();
        if(($count_bio == 1 || $count_chemistry == 1 || $count_science == 1 || $count_phy) && ($olevel['count_math_d'] == 1 || $olevel['count_math_a'] == 1) && $olevel['olevel'] >= 5)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $status = array($status_spm, $status_olevel);

        if(in_array(true, $status))
        {
            $programme_code = 'ILE12';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'ILE12';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ikr09($applicantt) //Korean Preparatory Course
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1)
        {
            $programme_code = 'IKR09';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'IKR09';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ibm20($applicantt) //Diploma in Business Management
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['spm'] >= 3)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $stpm = $this->stpm($applicantt);
        if($stpm['stpm'] >= 1)
        {
            $status_stpm = true;
        }else{
            $status_stpm = false;
        }

        $stam = $this->stam($applicantt);
        if($stam['stam'] >= 10)
        {
            $status_stam = true;
        }else{
            $status_stam = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['olevel'] >= 3)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $uec = $this->uec($applicantt);
        if($uec['uec'] >= 3)
        {
            $status_uec = true;
        }else{
            $status_uec = false;
        }

        $skm = $this->skm($applicantt);
        if($skm['skm'] >= 1 && $spm['spm'])
        {
            $status_skm = true;
        }else{
            $status_skm = false;
        }

        $mqf = $this->mqf($applicantt);
        if($mqf['mqf'] && $spm['spm'])
        {
            $status_mqf = true;
        }else{
            $status_mqf = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_mqf);

        if(in_array(true, $status))
        {
            $programme_code = 'IBM20';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IBM20';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ipg20($applicantt) //Diploma in Public Mangement and Governance
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['spm'] >= 3)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $stpm = $this->stpm($applicantt);
        if($stpm['stpm'] >= 1)
        {
            $status_stpm = true;
        }else{
            $status_stpm = false;
        }

        $stam = $this->stam($applicantt);
        if($stam['stam'] >= 10)
        {
            $status_stam = true;
        }else{
            $status_stam = false;
        }

        $olevel = $this->olevel($applicantt);
        if($olevel['olevel'] >= 3)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $uec = $this->uec($applicantt);
        if($uec['uec'] >= 3)
        {
            $status_uec = true;
        }else{
            $status_uec = false;
        }

        $mqf = $this->mqf($applicantt);
        if($mqf ==  1)
        {
            $status_mqf = true;
        }else{
            $status_mqf = false;
        }

        $skm = $this->skm($applicantt);
        if($spm['spm'] >= 1 && $skm == 1)
        {
            $status_skm = true;
        }else{
            $status_skm = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_mqf);

        if(in_array(true, $status))
        {
            $programme_code = 'IPG20';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IPG20';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function ihp20($applicantt) //Diploma in Scientific Halal Practice
    {
        $status = [];
        $spm = $this->spm($applicantt);

        $count_bio = $spm['app_spm']->where('subject',4551)->count();
        $count_chemistry = $spm['app_spm']->where('subject',4541)->count();
        $count_agama = $spm['app_spm']->where('subject',1223)->count();
        $count_melayu = $spm['app_spm']->where('subject',1103)->count();
        $count_sejarah = $spm['app_spm']->where('subject',1249)->count();
        $count_syariah = $spm['app_spm']->where('subject',5228)->count();
        $count_science = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->where('subject',1511)->where('grade_id','<=',4)->count();

        if($spm['count_math'] == 1 && $spm['count_eng'] == 1 && $count_melayu == 1 && $count_sejarah == 1 && ($count_agama == 1 || $count_syariah == 1)
        && (($count_chemistry == 1 && $count_bio == 1) || $count_science == 1) && $spm['spm'] >= 7)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $stpm = $this->stpm($applicantt);

        $count_bio = $stpm['app_stpm']->where('subject',964)->count();
        $count_chemistry = $stpm['app_stpm']->where('subject',952)->count();
        if(($stpm['count_math_m'] == 1 || $stpm['count_math_t'] == 1 ) && $count_bio == 1 && $stpm['count_eng'] == 1 && $count_chemistry == 1 && $stpm['stpm'] >= 4)
        {
            $status_stpm = true;
        }else{
            $status_stpm = false;
        }

        $app_alevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',5)->where('grade_id','<=',38)->get();
        $alevel = $app_alevel->count();

        $count_bio = $app_alevel->where('subject','A101')->count();
        $count_chemistry = $app_alevel->where('subject','A102')->count();
        if($count_bio == 1 && $count_chemistry == 1 && $alevel >= 3)
        {
            $status_alevel = true;
        }else{
            $status_alevel = false;
        }

        $olevel = $this->olevel($applicantt);

        $count_bio = $olevel['app_olevel']->where('subject','CIE5090')->count();
        $count_chemistry = $olevel['app_olevel']->where('subject','CIE5070')->count();
        $count_science = $olevel['app_olevel']->where('subject','CIE5129')->count();

        if(($count_bio == 1 || $count_chemistry == 1 || $count_science == 1) && $olevel['count_eng'] == 1 && ($olevel['count_math_d'] == 1 || $olevel['count_math_a'] == 1) && $olevel['olevel'] >= 3)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $sace = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',10)->where('cgpa','>=',50)->count();
        if($sace == 1)
        {
            $status_sace = true;
        }else{
            $status_sace = false;
        }

        $status = array($status_spm, $status_stpm, $status_alevel, $status_olevel, $status_sace);

        if(in_array(true, $status))
        {
            $programme_code = 'IHP20';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IHP20';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function iac20($applicantt) //Diploma in Accounting
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_math'] == 1 && $spm['count_eng'] == 1 && $spm['spm'] >= 3)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $stpm = $this->stpm($applicantt);
        if($spm['count_eng'] == 1 && ($stpm['count_math_m'] == 1 || $stpm['count_math_t'] == 1 ) && $stpm['stpm'] >= 2)
        {
            $status_stpm = true;
        }else{
            $status_stpm = false;
        }

        $stam = $this->stam($applicantt);
        if($spm['count_math'] == 1 && $spm['count_eng'] == 1 && $stam['stam'] >= 10)
        {
            $status_stam = true;
        }else{
            $status_stam = false;
        }

        $skm = $this->skm($applicantt);
        if($spm['count_math'] == 1 && $spm['count_eng'] == 1 && $skm['skm'] == 3)
        {
            $status_skm = true;
        }else{
            $status_skm = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_skm);

        if(in_array(true, $status))
        {
            $programme_code = 'IAC20';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'IAC20';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function iif20($applicantt) //Diploma in Islamic Finance
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_math'] == 1 && $spm['spm'] >= 3)
        {
            $status_spm = true;
        }else{
            $status_spm = false;
        }

        $stpm = $this->stpm($applicantt);
        if(($spm['count_math'] == 1 || $stpm['count_math_m'] == 1 || $stpm['count_math_t'] == 1) && $stpm['stpm'] >= 2)
        {
            $status_stpm = true;
        }else{
            $status_stpm = false;
        }

        $stam = $this->stam($applicantt);
        if($spm['count_math'] == 1 && $stam['stam'] >= 10)
        {
            $status_stam = true;
        }else{
            $status_stam = false;
        }

        $olevel = $this->olevel($applicantt);
        if(($olevel['count_math_a'] == 1 || $olevel['count_math_d'] == 1) && $olevel['olevel'] >= 4)
        {
            $status_olevel = true;
        }else{
            $status_olevel = false;
        }

        $uec = $this->uec($applicantt);
        if($uec['count_math'] == 1 && $uec['uec'] >= 4)
        {
            $status_uec = true;
        }else{
            $status_uec = false;
        }

        $skm = $this->skm($applicantt);
        if($spm['count_math'] == 1 && $skm['skm'] == 1 && $spm['spm'] >= 2)
        {
            $status_skm = true;
        }else{
            $status_skm = false;
        }

        $kkm = $this->kkm($applicantt);
        if($kkm['kkm'] == 1)
        {
            $status_kkm = true;
        }else{
            $status_kkm = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_kkm);

        if(in_array(true, $status))
        {
            $programme_code = 'IIF20';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IIF20';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac150($applicantt) //Certified Accounting Technician
    {
        $status = [];
        $spm = $this->spm($applicantt);
        $count_malay = $spm['app_spm']->where('subject',1103)->count();

        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $count_malay == 1 && $spm['spm'] >= 5)
        {
            $programme_code = 'PAC150';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'PAC150';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac170($applicantt) //Certified in Accounting, Finance & Business
    {
        $status = [];
        $spm = $this->spm($applicantt);
        $count_malay = $spm['app_spm']->where('subject',1103)->count();

        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $count_malay == 1 && $spm['spm'] >= 5)
        {
            $programme_code = 'PAC170';
            $this->accepted($applicantt, $programme_code);
        }else {
            $programme_code = 'PAC170';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac580($applicantt) //The Malaysian Institute of Certified Public Accountant
    {
        $status = [];
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->where('cgpa','>=',2.50)->count();
        if($bachelors == 1)
        {
            $programme_code = 'PAC580';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'PAC580';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac570($applicantt) //Institute of Chartered Accountants in England and Wales (ICAEW)
    {
        $status = [];
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->where('cgpa','>=',2.75)->count();
        if($bachelors == 1)
        {
            $status_bach = true;
        }else{
            $status_bach = false;
        }

        $icaew = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',17)->count();
        if($icaew == 1)
        {
            $status_icaew = true;
        }else{
            $status_icaew = false;
        }

        $status = array($status_bach, $status_icaew);

        if(in_array(true, $status))
        {
            $programme_code = 'PAC570';
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 'PAC570';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac552($applicantt) //The Association of Certified Chartered Accountant ACCA from CAT
    {
        $status = [];

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->where('cgpa','>=',2)->count();
        $cat = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',16)->where('cgpa','Pass')->count();
        if($muet >= 1 && $cat >= 1)
        {
            $programme_code = 'PAC552';
            $this->accepted($applicantt, $programme_code);
        }else
        {
            $programme_code = 'PAC552';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac551($applicantt) //The Association of Certified Chartered Accountant ACCA from Diploma
    {
        $status = [];

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->where('cgpa','>=',2)->count();
        $diploma = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',8)->where('cgpa','>=',3.00)->count();
        if($muet >= 1 && $diploma >= 1)
        {
            $programme_code = 'PAC551';
            $this->accepted($applicantt, $programme_code);
        }else
        {
            $programme_code = 'PAC551';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac553($applicantt) //The Association of Certified Chartered Accountant ACCA from Degree Full Time
    {
        $status = [];

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->where('cgpa','>=',2)->count();
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->where('cgpa','>=',2.50)->count();
        if($muet >= 1 && $bachelors >= 1)
        {
            $programme_code = 'PAC553';
            $this->accepted($applicantt, $programme_code);
        }else
        {
            $programme_code = 'PAC553';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function pac554($applicantt) //The Association of Certified Chartered Accountant ACCA from Degree Part Time
    {
        $status = [];

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->where('cgpa','>=',2)->count();
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->where('cgpa','>=',2.50)->count();
        if($muet >= 1 && $bachelors >= 1)
        {
            $programme_code = 'PAC554';
            $this->accepted($applicantt, $programme_code);
        }else
        {
            $programme_code = 'PAC554';
            $this->rejected($applicantt, $programme_code);
        }
    }

    public function checkrequirements()
    {
        $applicants = Applicant::where('applicant_status', NULL)->get()->toArray();
        $programme = Programme::all();
        foreach ($applicants as $applicantt)
        {
            $programme_1 = $applicantt['applicant_programme'];
            $programme_2 = $applicantt['applicant_programme_2'];
            $programme_3 = $applicantt['applicant_programme_3'];
            if(isset($applicantt['applicant_programme'])){
                $this->$programme_1($applicantt);
            }if(isset($applicantt['applicant_programme_2'])){
                $this->$programme_2($applicantt);
            }if(isset($applicantt['applicant_programme_3'])){
                $this->$programme_3($applicantt);
            }

        }
        return $this->indexs();
    }

    public function intakestatus(Request $request)
    {
        Applicant::where('id',$request->applicant_id)->update(['intake_id'=>$request->applicant_intake]);
        return response()->json(['success'=>true,'status'=>'success','message'=>'Intake has been updated']);
    }

    public function programmestatus(Request $request)
    {
        ApplicantStatus::where('applicant_id',$request->applicant_id)
        ->where('applicant_programme',$request->applicant_programme)
        ->delete();

        $applicant = Applicant::where('id',$request->applicant_id)->first();
        do {
            $year = substr((date("Y",strtotime($applicant->created_at))),-2);
            $random = mt_rand(1000,9999);
            $student_id = $year . '1117' . $random;
         } while ( ApplicantStatus::where('student_id', $student_id )->exists() );

        $data = [
            'applicant_id' => $request->applicant_id,
            'applicant_programme' => $request->applicant_programme,
            'applicant_major' => $request->applicant_major,
            'applicant_status' => $request->applicant_status,
            'student_id' => $student_id,
        ];

        Applicant::where('id',$request->applicant_id)->update(['applicant_status'=>$request->applicant_status]);

        ApplicantStatus::create($data);

        // $this->sendEmail($request->applicant_id);

        return response()->json(['success'=>true,'status'=>'success','message'=>'Data has been saved to datatbase','Data'=>$data]);
    }

    public function sendEmail($applicants_id)
    {
        $details = ApplicantStatus::where('applicant_id',$applicants_id)->where('applicant_status','3')->with(['applicant','programme','major'])->first();
        foreach($details as $detail)
        {
            $intakes = IntakeDetail::where('status', '1')->where('intake_code', $detail->applicant->intake_id)->where('intake_programme', $detail->applicant_programme)
            ->first();
        }
        $report = PDF::loadView('intake.pdf', compact('detail', 'intakes'));
        $data = [
            'receiver_name' => $details->applicant->applicant_name,
            'details' => 'This offer letter is appended with this email. Please refer to the attachment for your registration instructions.',
        ];

        Mail::send('intake.offer-letter', $data, function ($message) use ($details, $report) {
            $message->subject('Congratulations, ' . $details->applicant->applicant_name);
            $message->to(!empty($details->applicant->applicant_email) ? $details->applicant->applicant_email : 'jane-doe@email.com');
            $message->attachData($report->output(), 'Offer_Letter_' . $details->applicant->applicant_name . '.pdf');
        });
    }

}

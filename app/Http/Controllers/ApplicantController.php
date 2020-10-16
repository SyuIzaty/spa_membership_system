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
use App\Family;
use App\ApplicantEmergency;
use App\ApplicantGuardian;
use App\IntakeDetail;
use App\Intakes;
use App\Files;
use App\Batch;
use App\Status;
use App\ApplicantRecheck;
use DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ApplicantExport;
use App\Imports\ApplicantImport;
use Auth;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id) // Display applicant detail, academic result
    {
        $applicant = Applicant::where('id',$id)->with(['applicantContactInfo','applicantEmergency.emergencyOne','applicantGuardian.familyOne','applicantGuardian.familyTwo','applicantIntake','status','intakeDetail','applicantstatus'])->first();

        $batch_1 = IntakeDetail::where('intake_code',$applicant->intake_id)->where('status','1')->where('intake_programme',$applicant->applicant_programme)->first();

        $batch_2 = IntakeDetail::where('intake_code',$applicant->intake_id)->where('status','1')->where('intake_programme',$applicant->applicant_programme_2)->first();

        $batch_3 = IntakeDetail::where('intake_code',$applicant->intake_id)->where('status','1')->where('intake_programme',$applicant->applicant_programme_3)->first();

        $applicant_recheck = ApplicantRecheck::where('applicant_id', $id)->with(['programme'])->get();
        $qualification = Qualification::all();
        $country = Country::all();
        $marital = Marital::all();
        $religion = Religion::all();
        $race = Race::all();
        $gender = Gender::all();
        $state = State::all();
        $family = Family::all()->sortBy('family_name');
        $intake = Intakes::all();

        $spm = ApplicantResult::ApplicantId($id)->Spm()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','1');
        }])->get();

        $stpm = ApplicantResult::ApplicantId($id)->Stpm()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','2');
        }])->get();

        $stam = ApplicantResult::ApplicantId($id)->Stam()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','3');
        }])->get();

        $uec = ApplicantResult::ApplicantId($id)->Uec()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','4');
        }])->get();

        $alevel = ApplicantResult::ApplicantId($id)->Alevel()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','5');
        }])->get();

        $olevel = ApplicantResult::ApplicantId($id)->Olevel()->with(['grades','subjects','applicantAcademic','file'=>function($query){
            $query->where('fkey2','6');
        }])->Result()->get();

        $skm = ApplicantAcademic::ApplicantId($id)->Skm()->with(['file'=>function($query){
            $query->where('fkey2','7');
        }])->first();

        $diploma = ApplicantAcademic::ApplicantId($id)->Diploma()->with(['file'=>function($query){
            $query->where('fkey2','8');
        }])->first();

        $degree = ApplicantAcademic::ApplicantId($id)->where('type','9')->with(['file'=>function($query){
            $query->where('fkey2','9');
        }])->first();

        $sace = ApplicantAcademic::ApplicantId($id)->Sace()->with(['file'=>function($query){
            $query->where('fkey2','10');
        }])->first();

        $muet = ApplicantAcademic::ApplicantId($id)->Muet()->with(['file'=>function($query){
            $query->where('fkey2','11');
        }])->first();

        $matriculation = ApplicantAcademic::ApplicantId($id)->Matriculation()->with(['file'=>function($query){
            $query->where('fkey2','12');
        }])->first();

        $foundation = ApplicantAcademic::ApplicantId($id)->Foundation()->with(['file'=>function($query){
            $query->where('fkey2','13');
        }])->first();

        $mqf = ApplicantAcademic::ApplicantId($id)->Mqf()->with(['file'=>function($query){
            $query->where('fkey2','14');
        }])->first();

        $kkm = ApplicantAcademic::ApplicantId($id)->Kkm()->with(['file'=>function($query){
            $query->where('fkey2','15');
        }])->first();

        $cat = ApplicantAcademic::ApplicantId($id)->Cat()->with(['file'=>function($query){
            $query->where('fkey2','16');
        }])->first();

        $icaew = ApplicantAcademic::ApplicantId($id)->Icaew()->with(['file'=>function($query){
            $query->where('fkey2','17');
        }])->first();

        $batch = Applicant::ApplicantId($id)->with(['applicantIntake.intakeDetails'])->first();

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
        $applicant_status = Applicant::where('id',$id)->get();
        foreach($applicant_status as $app_stat)
        {
            // $activity = Activity::where('properties->attributes->applicant_id', $app_stat['applicant_id'])->get();
            $activity = Activity::where('subject_id',$app_stat['id'])->where('description','!=','created')->where('description','!=','updated')->get();
        }

        $applicant_status = Status::where('status_code','>=','3')->get();
        return view('applicant.display',compact('applicant','spm','stpm','stam','uec','alevel','olevel','diploma','degree','matriculation','muet','sace', 'aapplicant','country','marital','religion','race','gender','state','skm','mqf','kkm','cat','icaew','activity','intake','family','foundation','applicant_status', 'batch_1','batch_2','batch_3','applicant_recheck','qualification'));
    }

    public function updateApplicant(Request $request) // Update applicant detail
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

    public function updateEmergency(Request $request) // Update applicant emergency detail
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

    public function updateGuardian(Request $request) // Update applicant guardian detail
    {
        ApplicantGuardian::where('applicant_id',$request->id)->update($request->except(['_token']));
        return redirect()->back();
    }

    public function indexs()
    {
        return view('applicant.applicantresult');
    }

    public function applicant_incomplete()
    {
        return view('applicant.applicantincomplete');
    }

    public function applicant_pass()
    {
        return view('applicant.applicantpass');
    }

    public function applicant_fail()
    {
        return view('applicant.applicantfail');
    }

    public function applicant_offer()
    {
        return view('applicant.applicantoffer');
    }

    public function data_allapplicant() // Datatable: display unprocessed applicant
    {
        $applicant = Applicant::where('applicant_status',NULL)->orWhere('applicant_status','0')->orWhere('applicant_status','A1')->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','statusResultThree','programmeThree','applicantstatus','applicantIntake','status');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicantIntake->intake_code;
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
            // ->addColumn('bm',function($applicants){
            //     return $applicants->applicantresult->where('subject',1103)->isEmpty() ? '': $applicants->applicantresult->where('subject',1103)->first()->grades->grade_code;
            // })
            // ->addColumn('english',function($applicants){
            //     return $applicants->applicantresult->where('subject',1119)->isEmpty() ? '': $applicants->applicantresult->where('subject',1119)->first()->grades->grade_code;
            // })
            // ->addColumn('math',function($applicants){
            //     return $applicants->applicantresult->where('subject',1449)->isEmpty() ? '': $applicants->applicantresult->where('subject',1449)->first()->grades->grade_code;
            // })

           ->addColumn('action', function ($applicants) {
               return '<input type="checkbox" name="student_checkbox[]" value="'.$applicants->id.'" class="student_checkbox">
               <a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="fal fa-user"></i></a>'
               ;
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_passapplicant() // Datatable: applicant pass minimum requirement
    {
        $applicant = Applicant::where('programme_status','1')->orWhere('programme_status_2','1')->orWhere('programme_status_3','1')->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','statusResultThree','programmeThree','applicantstatus','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicantIntake->intake_code;
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

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="fal fa-user"></i></a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_rejectedapplicant() // Datatable: Applicant who does not meet minimum requirement
    {
        // $applicant = Applicant::where('applicant_status',NULL)->get();
        $applicant = Applicant::where('programme_status','2')->where('programme_status_2','2')->where('programme_status_3','2')->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','applicantstatus','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicantIntake->intake_code;
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

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="fal fa-user"></i></a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function data_offerapplicant() //Datatable: offer applicant
    {
        $applicant = Applicant::where('applicant_status','3')->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo','applicantstatus','applicantIntake','batch');
        return datatables()::of($applicants)
            ->addColumn('applicant_name',function($applicants)
            {
                return $applicants->applicant_name;
            })
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicantIntake->intake_code;
            })
            ->addColumn('action', function ($applicants) {
               return '<div class="btn-block pull-right">
               <a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary pull-right"> <i class="fal fa-user"></i></a>
               <a href="'.action('IntakeController@letter', ['applicant_id' => $applicants->id]).'" class="btn btn-sm btn-info pull-right"><i class="fal fa-envelope"></i></a>
               <a href="'.action('IntakeController@sendEmail', ['applicant_id' => $applicants->id, 'intake_id' => $applicants->intake_id]).'" class="btn btn-sm btn-primary pull-right"><i class="fal fa-file-alt"></i></a>
               </div>';
            })
            ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
            ->make(true);
    }

    public function data_incompleteapplicant() // Datatable: incomplete applicant
    {
        $applicant = Applicant::where('applicant_status','00')->get();
        $applicants = $applicant->load('programme','statusResult','statusResultTwo','programmeTwo','applicantIntake');


        return datatables()::of($applicants)
            ->addColumn('intake_id',function($applicants)
            {
                return $applicants->applicantIntake->intake_code;
            })
            ->addColumn('prog_name',function($applicants)
            {
                return isset($applicants->programme->programme_code) ? '<div style="color:'.$applicants->statusResultTwo->colour.'">'.$applicants->programme->programme_code.'</div>' : '';
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

           ->addColumn('action', function ($applicants) {
               return '<a href="/applicant/'.$applicants->id.'" class="btn btn-sm btn-primary"><i class="fal fa-user"></i></a>';
           })
           ->rawColumns(['prog_name','prog_name_2','prog_name_3','action'])
           ->make(true);
    }

    public function offeredprogramme()
    {
        $intake = Intakes::where('status','1')->with(['intakeDetails'])->get();
        return view('applicant.offeredprogramme', compact('intake'));
    }

    public function sponsorapplicant()
    {
        return view('applicant.sponsorapplicant');
    }

    public function import(Request $request) // Upload data from sponsor
    {
        $this->validate($request, [
            'import_file' => 'required',
        ]);

        Excel::import(new ApplicantImport, request()->file('import_file'));
        return back()->with('success','Applicant Imported');
    }

    public function applicant_all()
    {
        $intake = Intakes::all();
        $batch = Batch::all();
        $status = Status::all();
        $programme = Programme::all();
        return view('applicant.applicantall', compact('intake', 'batch', 'status', 'programme'));
    }

    public function export(Request $request)
    {
        $intake = $request->intake;
        $batch = $request->batch;
        $programme = $request->programme;
        $status = $request->status;

        return Excel::download(new ApplicantExport($intake, $batch, $programme, $status), 'applicant.xlsx');
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
        Applicant::where('id',$applicantt['id'])->update(['applicant_status'=>'5']);

        $app = Applicant::where('id',$applicantt['id'])->first();
        if($app['programme_status'] == '2' && $app['programme_status_2'] == '2' && $app['programme_status_3'] == '2')
        {
            ApplicantRecheck::create([
                'applicant_id' => $app['id'],
                'programme_code' => $programme_code,
            ]);
        }
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

        $status_2 = Applicant::where('id',$applicantt['id'])->where('applicant_programme_2',NULL)->first();
        $status_3 = Applicant::where('id',$applicantt['id'])->where('applicant_programme_3',NULL)->first();
        if($status_2 || $status_3){
            $status_3->programme_status_3 = '2';
            $status_3->save();
        }if($status_2){
            $status_2->programme_status_2 = '2';
            $status_2->save();
        }

        Applicant::where('id',$applicantt['id'])->update(['applicant_status'=>'5']);
    }

    public function spm($applicantt)
    {
        $app_spm = ApplicantResult::where('applicant_id',$applicantt['id'])->Spm()->where('grade_id','<=',8)->get();
        $spm = $app_spm->count();
        $count_eng = $app_spm->where('subject',1119)->count();
        $count_math = $app_spm->where('subject',1449)->count();

        return compact('applicantt', 'app_spm', 'spm', 'count_eng', 'count_math');
    }

    public function stpm($applicantt)
    {
        $app_stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->Stpm()->where('grade_id','<=',17)->get();
        $stpm = $app_stpm->count();

        $count_math_m = $app_stpm->where('subject',950)->count();
        $count_math_t = $app_stpm->where('subject',954)->count();
        $count_eng = $app_stpm->where('subject',920)->count();
        return compact('app_stpm', 'stpm', 'count_math_m', 'count_math_t', 'count_eng');
    }

    public function stam($applicantt)
    {
        $app_stam = ApplicantResult::where('applicant_id',$applicantt['id'])->Stam()->where('grade_id','<=',15)->get();
        $stam = $app_stam->count();

        return compact('app_stam', 'stam');
    }

    public function uec($applicantt)
    {
        $app_uec = ApplicantResult::where('applicant_id',$applicantt['id'])->Uec()->where('grade_id','<=',25)->get();
        $uec = $app_uec->count();
        $count_math = $app_uec->where('subject','UEC104')->count();
        return compact('app_uec', 'uec', 'count_math');
    }

    public function olevel($applicantt)
    {
        $app_olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->Olevel()->where('grade_id','<=',45)->get();
        $olevel = $app_olevel->count();
        $count_eng = $app_olevel->where('subject','CIE1119')->count();
        $count_math_a = $app_olevel->where('subject','CIE4937')->count();
        $count_math_d = $app_olevel->where('subject','CIE4024')->count();
        return compact('applicantt', 'app_olevel', 'olevel', 'count_eng', 'count_math_a', 'count_math_d');
    }

    public function mqf($applicantt)
    {
        $mqf = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Mqf()->where('applicant_cgpa','>=',2.00)->count();
        return compact('mqf');
    }

    public function skm($applicantt)
    {
        $skm = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Skm()->count();
        return compact('skm');
    }

    public function kkm($applicantt)
    {
        $kkm = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Kkm()->where('applicant_cgpa','>=',2.00)->count();
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

    public function iam11($applicantt) //SACE International
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
            $programme_code = 'IAM11';
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 'IAM11';
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

        $sace = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Sace()->where('applicant_cgpa','>=',50)->count();
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
        $bachelors = ApplicantAcademic::where('applicant_id',$applicantt['id'])->where('type','9')->where('applicant_cgpa','>=',2.50)->count();
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
        $bachelors = ApplicantAcademic::where('applicant_id',$applicantt['id'])->where('type','9')->where('applicant_cgpa','>=',2.75)->count();
        if($bachelors == 1)
        {
            $status_bach = true;
        }else{
            $status_bach = false;
        }

        $icaew = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Icaew()->count();
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

        $muet = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Muet()->where('applicant_cgpa','>=',2)->count();
        $cat = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Cat()->where('applicant_cgpa','Pass')->count();
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

        $muet = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Muet()->where('applicant_cgpa','>=',2)->count();
        $diploma = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Diploma()->where('applicant_cgpa','>=',3.00)->count();
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

        $muet = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Muet()->where('applicant_cgpa','>=',2)->count();
        $bachelors = ApplicantAcademic::where('applicant_id',$applicantt['id'])->where('type','9')->where('applicant_cgpa','>=',2.50)->count();
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

        $muet = ApplicantAcademic::where('applicant_id',$applicantt['id'])->Muet()->where('applicant_cgpa','>=',2)->count();
        $bachelors = ApplicantAcademic::where('applicant_id',$applicantt['id'])->where('type','9')->where('applicant_cgpa','>=',2.50)->count();
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
        $applicants = Applicant::where('applicant_status', NULL)->orWhere('applicant_status','0')->orWhere('applicant_status','A1')->get()->toArray();
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
            Applicant::requirementCheck($applicantt['id']);
        }
        return $this->indexs();
    }

    public function applicantcheck(Request $request)
    {
        foreach ($request->student_checkbox as $applicant_id) {
            $applicants = Applicant::where('id',$applicant_id)->get()->toArray();
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
            Applicant::requirementCheck($applicantt['id']);
        }
        return redirect()->back();
    }

    public function test()
    {
        $test = Intakes::where('status','1')->with(['intakeDetails'=>function($query){
            $query->where('status','1');
        }])->get();
        foreach($test->first()->intakeDetails as $tests){
            dump($tests->intake_programme);
        }
    }

    public function checkIndividual(Request $request)
    {
        $applicants = Applicant::where('id', $request->applicant_id)->get()->toArray();
        // $programme = Programme::all();
        $programme = Intakes::where('status','1')->with(['intakeDetails'=>function($query){
            $query->where('status','1');
        }])->get();
        foreach ($applicants as $applicantt) {
            foreach ($programme->first()->intakeDetails as $programmes) {
                $programme_func = $programmes->intake_programme;
                $this->$programme_func($applicantt);
            }
        }
        Applicant::recheckQualification($applicantt['id']);
        return redirect()->back();
    }

    public function qualifiedProgramme(Request $request)
    {
        $applicant = Applicant::where('id',$request->applicant_id)->first();
        do {
            $year = substr((date("Y",strtotime($applicant->created_at))),-2);
            $random = mt_rand(1000,9999);
            $student_id = $year . '1117' . $random;
         } while ( Applicant::where('student_id', $student_id )->exists() );

        Applicant::where('id',$request->applicant_id)->update(['offered_programme' => $request->programme_code, 'offered_major' => $request->major, 'applicant_status' => '3', 'student_id' => $student_id]);

        $intake = Applicant::where('id',$request->applicant_id)->where('offered_programme',$request->programme_code)->where('offered_major',$request->major)->with(['intakeDetail'=>function($query) use ($request){
            $query->where('status','1')->where('intake_programme',$request->programme_code);
        }])->first();

        Applicant::updateStatus($request->applicant_id, $request->programme_code, $request->major);
        return redirect()->back();

        if(isset($intake->intakeDetail->batch_code)){
            $offer = Applicant::where('id',$request->applicant_id)->update(['batch_code' => $intake->intakeDetail->batch_code]);
        }else{
            Applicant::where('id',$request->applicant_id)->update(['offered_programme' => '', 'offered_major' => '', 'applicant_status' => '5', 'student_id' => '']);
            return '<script type="text/javascript">alert("Programme not offered for this intake");history.go(-1);;
            </script>';
        }

        return redirect()->back();
    }

    public function intakestatus(Request $request)
    {
        Applicant::where('id',$request->applicant_id)->update(['intake_id'=>$request->intake_id]);
        Applicant::changeIntake($request->applicant_id);
        return redirect()->back();
    }

    // public function programmestatus(Request $request)
    // {
    //     $applicant = Applicant::where('id',$request->applicant_id)->first();
    //     do {
    //         $year = substr((date("Y",strtotime($applicant->created_at))),-2);
    //         $random = mt_rand(1000,9999);
    //         $student_id = $year . '1117' . $random;
    //      } while ( Applicant::where('student_id', $student_id )->exists() );


    //     Applicant::where('id',$request->applicant_id)->update(['applicant_status'=>$request->applicant_status, 'offered_programme'=>$request->applicant_programme, 'offered_major'=>$request->applicant_major, 'batch_code'=>$request->batch_code ,'student_id'=>$student_id]);

    //     return response()->json(['success'=>true,'status'=>'success','message'=>'Data has been saved to database']);
    // }

    public function cancelOffer(Request $request)
    {
        $applicant = Applicant::where('id',$request->applicant_id)->first();
        ApplicantStatus::updateOrCreate([
            'applicant_id' => $request->applicant_id,
        ],[
            'applicant_programme' => $applicant->offered_programme,
            'applicant_major' => $applicant->offered_major,
            'applicant_status' => '6',
            'cancel_reason' => $request->cancel_reason,
        ]);
        return redirect()->back();
    }

    public function applicantstatus(Request $request)
    {
        $applicant = Applicant::where('id',$request->id)->first();
        do {
            $year = substr((date("Y",strtotime($applicant->created_at))),-2);
            $random = mt_rand(1000,9999);
            $student_id = $year . '1117' . $random;
         } while ( Applicant::where('student_id', $student_id )->exists() );

        Applicant::where('id',$request->id)->update(['offered_programme' => $request->applicant_programme, 'offered_major' => $request->applicant_major, 'applicant_status' => '3', 'batch_code' => $request->batch_code, 'student_id' => $student_id, 'applicant_qualification' => $request->applicant_qualification]);
        Applicant::updateStatus($applicant['id'], $request->applicant_programme, $request->applicant_major);
        return redirect()->back();
    }

    public function sendUpdateApplicant(Request $request)
    {
        foreach($request->check as $batch_code){
            $applicant = Applicant::where('batch_code',$batch_code)->where('intake_id',$request->intake_id)->where('applicant_status','3')->get();
            foreach($applicant as $apps){
                $this->sendEmail($apps['id']);
            }
        }
        return redirect()->back()->with('message', 'Email send and status updated');
    }

    public function sendEmail($applicants_id)
    {
        $detail = Applicant::where('id',$applicants_id)->where('applicant_status','3')->with(['offeredMajor','offeredProgramme'])->first();

        $intakes = IntakeDetail::where('status', '1')->where('intake_code', $detail->intake_id)->where('intake_programme', $detail->offered_programme)->first();

        $report = PDF::loadView('intake.pdf', compact('detail', 'intakes'));
        $data = [
            'receiver_name' => $detail->applicant_name,
            'details' => 'This offer letter is appended with this email. Please refer to the attachment for your registration instructions.',
        ];

        Mail::send('intake.offer-letter', $data, function ($message) use ($detail, $report) {
            $message->subject('Congratulations, ' . $detail->applicant_name);
            $message->to(!empty($detail->applicant_email) ? $detail->applicant_email : 'jane-doe@email.com');
            $message->attachData($report->output(), 'Offer_Letter_' . $detail->applicant_name . '.pdf');
        });

        Applicant::where('id',$applicants_id)->update(['applicant_status'=>'3A']);

        IntakeDetail::where('intake_code',$detail->intake_id)->where('batch_code',$detail['batch_code'])->update(['intake_status'=>'Offered']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\ApplicantResult;
use App\ApplicantStatus;
use App\ApplicantContact;
use App\Grades;
use App\RequirementSubject;
use App\Programme;

use App\Qualification;
use App\Subject;
use App\ApplicantEmergency;
use App\ApplicantGuardian;
use App\RequirementStatus;
use DB;

class ApplicantController extends Controller
{
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
 
     foreach ($programme as $program)

    // Redirect the user to the created applicant with a success notification
    return redirect(route('applicant.profile',$applicant,$programme))->with('notification', 'Applicant created!');
       
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
     
    

    public function prefprogramme(Applicant $applicant,Programme $programme)
    {
        
        $programme = DB::table('programmes')
        ->select('*')
        ->where('id', $applicant->applicant_programme)
        ->get(); 
        $programme = DB::select('select * from programmes');
       
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
    
        // Redirect the user to the created post with a success notification
        return redirect(route('applicant.profile',$applicant))->with('notification', 'Applicant Updated!');
     
    }

    public function storecontact(Request $request,Applicant $applicant, ApplicantContact $applicantcontact)
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

        $applicantcontact = ApplicantContact::create($validated);
        $appcontact = DB::table('applicant')
    ->select('*')
    ->where('id', $applicantcontact->applicant_id)
    ->get();
    foreach ($appcontact as $app);
        //DB::table()->join('applicant','id','=','applicant_contact_info.applicant_id');
      
        //dd($applicantcontact);
     //return view ('applicant.contact',compact('applicant','applicantcontact'))->with('notification', 'Contact Updated!');
     return redirect(route('applicant.contactinfo',$applicant,$applicantcontact,$appcontact))->with('notification', 'Contact created!');    
    }

    public function contact(Applicant $applicant,ApplicantContact $applicantcontact)
    { 
        return view ('applicant.contact',compact('applicant','applicantcontact'));
    }

    public function contactinfo(Applicant $applicant,ApplicantContact $applicantcontact)
    { 
        return view ('applicant.contactinfo',compact('applicant','applicantcontact'));
    }

    public function updatecontact(Request $request,Applicant $applicant, ApplicantContact $applicantcontact)
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
    public function changestatus(Request $request)
    {
        $input = $request->all();

        $status = DB::table('applicant')
        ->where('id','=',$input['id'])
        ->update([
            'applicant_status' =>$input['select']
        ]);

        $applicant =DB::table('applicant')
        ->where('Id','=',$input['id'])
        ->first();
        
        return $applicant->applicant_status;
    }

    public function show($id)
    {
        $applicant = Applicant::find($id);
        $applicantresult = ApplicantResult::where('applicant_id',$id)->get();

        $applicants = Applicant::where('id',$id)->get()->toArray();
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
            $spm_result = ApplicantResult::where('applicant_id',$id)->where('type',1)->get();
            $spm = $spm_result->load('grades','subjects');
            
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
            
            $applicant_guardian = ApplicantGuardian::where('applicant_id',$id)->first();

            $applicant_emergency = ApplicantEmergency::where('applicant_id',$id)->first();

            $applicant2 = Applicant::where('id',$id)->get()->toArray();
            foreach($applicant2 as $applicantstat)
            {
                $programme_1['programme_1'] = Programme::where('id',$applicantstat['applicant_programme'])->get();
                $programme_2['programme_2'] = Programme::where('id',$applicantstat['applicant_programme_2'])->get();
                $programme_3['programme_3'] = Programme::where('id',$applicantstat['applicant_programme_3'])->get();

                $dataappl[] = array_merge($applicantstat, $programme_1, $programme_2, $programme_3);
            }
            
            $aapplicant = $dataappl;
        return view('applicant.display',compact('applicant','spm','stpm','stam','uec','alevel','olevel', 'applicantresult','total_point', 'programmestatus', 'aapplicant','applicant_guardian','applicant_emergency'));
    }

    public function indexs()
    {
        $dataappl = [];
        $programme = [];
        $applicant = Applicant::where('applicant_status',NULL)->get()->toArray();

        foreach($applicant as $applicantstat)
        {
            $programme_1['programme_1'] = Programme::where('id',$applicantstat['applicant_programme'])->select('programme_code')->get();
            $programme_2['programme_2'] = Programme::where('id',$applicantstat['applicant_programme_2'])->select('programme_code')->get(); 
            $programme_3['programme_3'] = Programme::where('id',$applicantstat['applicant_programme_3'])->select('programme_code')->get(); 

            $bm_res = ApplicantResult::where('applicant_id',$applicantstat['id'])->where('subject',1103)->where('type',1)->get();
            $bm['bm'] = $bm_res->load('grades');

            $eng_res = ApplicantResult::where('applicant_id',$applicantstat['id'])->where('subject',1119)->where('type',1)->get();
            $eng['eng'] = $eng_res->load('grades');

            $math_res = ApplicantResult::where('applicant_id',$applicantstat['id'])->where('subject',1449)->where('type',1)->get();
            $math['math'] = $math_res->load('grades');
            
            $dataappl[] = array_merge($applicantstat, $programme_1, $programme_2, $programme_3, $bm, $eng, $math);     
        }

        $applicant_offer = ApplicantStatus::where('applicant_status','Selected')->get();
        $app_offer = $applicant_offer->load('programme','applicant');

        $aapplicant = $dataappl;
        return view('applicant.applicantresult', compact('aapplicant','app_offer'));
    }

    public function testCollection()
    {
        $applicant = Applicant::where('applicant_status',NULL)->get();
        $applicants = $applicant->load('programme','applicantresult.grades');  
        // $applicants = $applicants[0]->applicantresult->where('subject','1103')->first()->grades->grade_code;//->pluck('grade_code');

        // foreach($applicants as $a)
        // {
        //     echo $a->grades->grade_code;
        // }
    }

    public function data_allapplicant()
    {
        $applicant = Applicant::where('applicant_status',NULL)->get();
        $applicants = $applicant->load('programme','applicantresult.grades','statusResult','statusResultTwo','programmeTwo');
     

        return datatables()::of($applicants)
            ->addColumn('prog_name',function($applicants)
            {
                return '<div style="color:'.$applicants->statusResult->colour.'">'.$applicants->programme->programme_code.'</div>';
            })
            ->addColumn('prog_name_2',function($applicants)
            {
                return '<div style="color:'.$applicants->statusResultTwo->colour.'">'.isset($applicants->programmeTwo->programme_code) ? $applicants->programmeTwo->programme_code.$applicants->programme_status_2 : ''.'</div>';
    
            })
            ->addColumn('prog_name_3',function($applicants)
            {
                return isset($applicants->programmeThree->programme_code) ? $applicants->programmeThree->programme_code.$applicants->programme_status_3 : '';
    
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
    }

    public function rejected($applicantt, $programme_code, $reason_failed)
    {
        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status = '2';
            $programme_status->reason_fail = $reason_failed;
            $programme_status->save();
        }
    
        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_2',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status_2 = '2';
            $programme_status->reason_fail_2 = $reason_failed;
            $programme_status->save();
        }
    
        $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_3',$programme_code)->first();
        if($programme_status){
            $programme_status->programme_status_3 = '2';
            $programme_status->reason_fail_3 = $reason_failed;
            $programme_status->save();
        }
        
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
        $app_stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->where('grade_id','<=',32)->get();
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
        $app_uec = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',4)->where('grade_id','<=',22)->get();
        $uec = $app_uec->count();    
        $count_math = $app_uec->where('subject','UEC104')->count();
        return compact('app_uec', 'uec', 'count_math');
    }

    public function olevel($applicantt)
    {
        $app_olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->where('grade_id','<=',46)->get();
        $olevel = $app_olevel->count();    
        $count_eng = $app_olevel->where('subject','CIE1119')->count();
        $count_math_a = $app_olevel->where('subject','CIE4937')->count();
        $count_math_d = $app_olevel->where('subject','CIE4024')->count();
        return compact('applicantt', 'app_olevel', 'olevel', 'count_eng', 'count_math_a', 'count_math_d');
    }

    public function mqf($applicantt)
    {
        $mqf = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->where('cgpa','>=',2.00)->count();
        return compact('mqf');
    }

    public function skm($applicantt)
    {
        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->count();
        return compact('skm');
    }

    public function komuniti($applicantt)
    {
        $komuniti = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->count();
        return compact('komuniti');
    }

    public function kkm($applicantt)
    {
        $kkm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',10)->where('cgpa','>=',2.00)->count();
        return compact ('kkm');
    }

    public function iat($applicantt) //American Degree Transfer Programme
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
            $programme_code = 1;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 1;
            if($status_spm == false) 
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($status_olevel == false)
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }                        
    }

    public function ial($applicantt) //A Level Programme
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
            $programme_code = 2;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 2;
            if($status_spm == false) 
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false)
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }                        
    }

    public function igr($applicantt) //A Level German Programme
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
            $programme_code = 3;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 3;
            if($status_spm == false) 
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false)
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }                   
    }

    public function iam($applicantt) //SACE International
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
            $programme_code = 4;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 4;
            if($status_spm == false) 
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false)
            {
                $reason_failed = 'Fail mathematics or english or less than 5 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }                                           
    }

    public function ile($applicantt) //Japanese Preparatory Course
    {
        $status = [];
        $app_spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->where('grade_id','<=',8)->get();
        $spm = $app_spm->count();    

        $count_math = $app_spm->where('subject',1449)->count();
        $count_bio = $app_spm->where('subject',4551)->count();
        $count_chem = $app_spm->where('subject',4541)->count();
        $count_phy = $app_spm->where('subject',4531)->count();
        $count_sci = $app_spm->where('subject',1511)->count();
        if($count_math == 1 && ($count_bio == 1 || $count_chem == 1 || $count_phy == 1 || $count_sci == 1) && $spm >= 5)
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
            $programme_code = 5;
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 5; 
            if($status_spm == false)
            {
                $reason_failed = 'Fail mathematics or biology or chemistry or physics or science SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($status_olevel == false)
            {
                $reason_failed = 'Fail mathematics or biology or chemistry or physics or science O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }
    }

    public function ikr($applicantt) //Korean Preparatory Course
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_eng'] == 1)
        {
            $programme_code = 6;
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 6;
                $reason_failed = 'Fail english SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            
        }
    }

    public function dbm($applicantt) //Diploma in Business Management
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

        $komuniti = $this->komuniti($applicantt);
        if($komuniti['komuniti'] >= 1 && $spm['spm'])
        {
            $status_komuniti = true;
        }else{
            $status_komuniti = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_mqf, $status_komuniti);

        if(in_array(true, $status))
        {
            $programme_code = 7;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 7;
            if($status_spm == false) {
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stpm == false){
                $reason_failed = 'Less than 3 credit STPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stam == false){
                $reason_failed = 'Less than Maqbul STAM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false){
                $reason_failed = 'Less than 3 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_uec == false){
                $reason_failed = 'Less than 3 credit UEC';
                $this->rejected($applicantt, $programme_code, $reason_failed);   
            }if($skm == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($mqf == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($komuniti == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }         
    }

    public function dpmg($applicantt) //Diploma in Public Mangement and Governance
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

        $komuniti = $this->komuniti($applicantt);
        if($spm['spm'] >= 1 && $skm == 1)
        {
            $status_komuniti = true;
        }else{
            $status_komuniti = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_mqf, $status_komuniti);

        if(in_array(true, $status))
        {
            $programme_code = 8;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 8;
            if($status_spm == false) {
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stpm == false){
                $reason_failed = 'Less than 1 credit STPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stam == false){
                $reason_failed = 'Less than Maqbul STAM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false){
                $reason_failed = 'Less than 3 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_uec == false){
                $reason_failed = 'Less than 3 credit UEC';
                $this->rejected($applicantt, $programme_code, $reason_failed);   
            }if($skm == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($mqf == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($komuniti == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }        
    }

    public function dshp($applicantt) //Diploma in Scientific Halal Practice
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

        $app_alevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',5)->where('grade_id','<=',39)->get();
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
            $programme_code = 9;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 9;
            if($status_spm == false) {
                $reason_failed = 'Fail Biology or Chemistry or Science or Sejarah or Syariah or Mathematics SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stpm == false){
                $reason_failed = 'Fail Biology or Chemistry or Mathematics or English or Less than 4 credit STPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_alevel == false){
                $reason_failed = 'Fail Biology or Chemistry or less than 3 credit A Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false){
                $reason_failed = 'Fail Biology or Chemistry or Science or English or Mathematics or Less than 3 credit UEC';
                $this->rejected($applicantt, $programme_code, $reason_failed);   
            }if($sace == false){
                $reason_failed = 'Less than 50 SACE';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }        
    }

    public function dia($applicantt) //Diploma in Accounting
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_math'] == 1 && $spm['count_eng'] == 1 && $spm['spm'] >= 5)
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
            $programme_code = 10;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 10;
            if($status_spm == false) {
                $reason_failed = 'Fail English or Mathematics or Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stpm == false){
                $reason_failed = 'Fail English or Mathematics or Less than 3 credit STPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stam == false){
                $reason_failed = 'Less than Maqbul STAM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($skm == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }
    }

    public function dif($applicantt) //Diploma in Islamic Finance
    {
        $status = [];
        $spm = $this->spm($applicantt);
        if($spm['count_math'] == 1 && $spm['spm'] >= 4)
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

        $komuniti = $this->komuniti($applicantt);
        if($spm['count_math'] == 1 && $komuniti['komuniti'] == 1 && $spm['spm'] >= 2)
        {
            $status_komuniti = true;
        }else{
            $status_komuniti = false;
        }

        $kkm = $this->kkm($applicantt);
        if($kkm['kkm'] == 1)
        {
            $status_kkm = true;
        }else{
            $status_kkm = false;
        }

        $status = array($status_spm, $status_stpm, $status_stam, $status_olevel, $status_uec, $status_skm, $status_komuniti);

        if(in_array(true, $status))
        {
            $programme_code = 11;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 11;
            if($status_spm == false) {
                $reason_failed = 'Fail mathematics or Less than 4 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stpm == false){
                $reason_failed = 'Fail mathematics or Less than 3 credit STPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_stam == false){
                $reason_failed = 'Less Maqbul STAM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_olevel == false){
                $reason_failed = 'Fail Mathematics or Less than 4 credit O Level';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_uec == false){
                $reason_failed = 'Fail Mathematics or Less than 4 credit UEC';
                $this->rejected($applicantt, $programme_code, $reason_failed);   
            }if($skm == false){
                $reason_failed = 'Fail Mathematics or Less than 2 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if($kkm == false){
                $reason_failed = 'Less than 3 credit SPM';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }         
    }

    public function cat($applicantt) //Certified Accounting Technician
    {
        $status = [];
        $spm = $this->spm($applicantt);
        $count_malay = $spm['app_spm']->where('subject',1103)->count();

        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $count_malay == 1 && $spm['spm'] >= 5)
        {
            $programme_code = 12;
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 12;
            $reason_failed = 'Fail Mathematics or English or Bahasa Melayu or Less than 5 credit SPM';
            $this->rejected($applicantt, $programme_code, $reason_failed);
        }
    }

    public function cfab($applicantt) //Certified in Accounting, Finance & Business
    {
        $status = [];
        $spm = $this->spm($applicantt);
        $count_malay = $spm['app_spm']->where('subject',1103)->count();

        if($spm['count_eng'] == 1 && $spm['count_math'] == 1 && $count_malay == 1 && $spm['spm'] >= 5)
        {
            $programme_code = 13;
            $this->accepted($applicantt, $programme_code);
        }else {
            $programme_code = 13;
            $reason_failed = 'Fail English or Mathematics or Bahasa Melayu or Less than 3 credit SPM';
            $this->rejected($applicantt, $programme_code, $reason_failed);
        }        
    }

    public function micpa($applicantt) //The Malaysian Institute of Certified Public Accountant
    {
        $status = [];
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->where('cgpa','>=',2.50)->count();
        if($bachelors == 1)
        {
            $programme_code = 14;
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 14;
            $reason_failed = 'CGPA less than 2.50';
            $this->rejected($applicantt, $programme_code, $reason_failed);
            
        }
    }

    public function acca($applicantt) //The Association of Certified Chartered Accountant 
    {
        $status = [];

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',18)->where('cgpa','>=',2)->count();
        $matriculations = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',12)->where('cgpa','>=',2.50)->count();
        $diploma = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',15)->where('cgpa','>=',3.00)->count();
        $cat = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',16)->where('cgpa','Pass')->count();
        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->where('cgpa','>=',2.50)->count();
        if($muet >= 1 && ($matriculations >= 1 || $diploma >= 1 || $bachelors >= 1 || $cat >= 1))
        {
            $programme_code = 15;
            $this->accepted($applicantt, $programme_code);
        }else
        {
            $programme_code = 15;
            $reason_failed = 'Does not exceed minimum requirement';
            $this->rejected($applicantt, $programme_code, $reason_failed);
        }
    }

    public function aca($applicantt) 
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
            $programme_code = 16;
            $this->accepted($applicantt, $programme_code);
        }else{
            $programme_code = 16;
            if($status_bach == false) {
                $reason_failed = 'Less than 2.75 CGPA';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }if ($status_icaew == false){
                $reason_failed = 'Fail ICAEW';
                $this->rejected($applicantt, $programme_code, $reason_failed);
            }
        }
    }

    public function checkrequirements()
    {
        $applicants = Applicant::where('applicant_status', NULL)->get()->toArray();
        $programme = Programme::all();
        foreach ($applicants as $applicantt)
        {
            $this->iat($applicantt);
            $this->ial($applicantt);
            $this->igr($applicantt);
            $this->iam($applicantt);
            $this->ile($applicantt);
            $this->ikr($applicantt);
            $this->dbm($applicantt);
            $this->dpmg($applicantt);
            $this->dshp($applicantt);
            $this->dia($applicantt);
            $this->dif($applicantt);
            $this->cat($applicantt);
            $this->cfab($applicantt);
            $this->micpa($applicantt);
            $this->acca($applicantt);
            $this->aca($applicantt);

        }
        return $this->indexs();
    }

    public function programmestatus(Request $request)
    {
        ApplicantStatus::where('applicant_id',$request->applicant_id)
        ->where('applicant_programme',$request->applicant_programme)
        ->delete();

        $data = [
            'applicant_id' => $request->applicant_id,
            'applicant_programme' => $request->applicant_programme,
            'applicant_status' => $request->applicant_status
        ];

        ApplicantStatus::create($data);

        return response()->json(['success'=>true,'status'=>'success','message'=>'Data has been saved to datatbase','Data'=>$data]);
    }
}
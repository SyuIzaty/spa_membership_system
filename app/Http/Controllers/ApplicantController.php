<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\ApplicantResult;
use App\ApplicantStatus;
use App\Grades;
use App\RequirementSubject;
use App\Programme;
use App\Qualification;
use App\Subject;
use App\ApplicantEmergency;
use App\ApplicantGuardian;
use DB;

class ApplicantController extends Controller
{
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

    public function indexs()
    {
        $programme = [];
        $applicant = Applicant::where('applicant_status',NULL)->get()->toArray();

        foreach($applicant as $applicantstat)
        {
            $programme_1['programme_1'] = Programme::where('id',$applicantstat['applicant_programme'])->select('programme_name')->get();
            $programme_2['programme_2'] = Programme::where('id',$applicantstat['applicant_programme_2'])->select('programme_name')->get(); 
            $programme_3['programme_3'] = Programme::where('id',$applicantstat['applicant_programme_3'])->select('programme_name')->get(); 
            
            $dataappl[] = array_merge($applicantstat, $programme_1, $programme_2, $programme_3);  
            
        }

        $aapplicant = $dataappl;
        return view('applicant.applicantresult', compact('aapplicant'));
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
            $spm = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',1)
                ->where('applicantresult.type',1)
                ->get();

            $stpm = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',2)
                ->where('applicantresult.type',2)
                ->get();
            
            $stam = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',3)
                ->where('applicantresult.type',3)
                ->get();

            $uec = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',4)
                ->where('applicantresult.type',4)
                ->get();

            $alevel = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',5)
                ->where('applicantresult.type',5)
                ->get();

            $olevel = ApplicantResult::join('subjects', 'applicantresult.subject', '=', 'subjects.subject_code')
            ->join('grades','applicantresult.grade','=','grades.grade_point')
                ->select('applicantresult.*','subjects.*','grades.*')
                ->where('applicantresult.applicant_id',$id)
                ->where('grades.grade_type',6)
                ->where('applicantresult.type',6)
                ->get();

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

    public function accepted($applicantt, $programme_code)
    {
        if($applicantt['applicant_programme'] == $programme_code)
        {
            $statuss = 'Accepted';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status = $statuss;
                $programme_status->save();
            }
        }
        if($applicantt['applicant_programme_2'] == $programme_code)
        {
            $statuss = 'Accepted';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_2',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status_2 = $statuss;
                $programme_status->save();
            }
        }
        if($applicantt['applicant_programme_3'] == $programme_code)
        {
            $statuss = 'Accepted';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_3',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status_3 = $statuss;
                $programme_status->save();
            }
        }
    }

    public function rejected($applicantt, $programme_code)
    {
        if($applicantt['applicant_programme'] == $programme_code)
        {
            $statuss = 'Rejected';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status = $statuss;
                $programme_status->save();
            }
        }
        if($applicantt['applicant_programme_2'] == $programme_code)
        {
            $statuss = 'Rejected';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_2',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status_2 = $statuss;
                $programme_status->save();
            }
        }
        if($applicantt['applicant_programme_3'] == $programme_code)
        {
            $statuss = 'Rejected';
            $programme_status = Applicant::where('id',$applicantt['id'])->where('applicant_programme_3',$programme_code)->first();
            if($programme_status)
            {
                $programme_status->programme_status_3 = $statuss;
                $programme_status->save();
            }
        }
    }

    public function iat($applicantt) //American Degree Transfer Programme
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();
        
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }
        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_eng = array_keys(array_column($olevel->toArray(), 'subject'), 1123);
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 4037);
        $count_math_d = array_keys(array_column($olevel->toArray(), 'subject'), 4024);
        if($count_eng != []  && ($count_math_a != [] || $count_math_d != []))
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 3.00)
                    {
                        $creditolevel = 0;
                    }else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;
                }
                if($total_creditolevel >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        
        if(in_array(true, $status))
        {
            $programme_code = 1;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 1;
            $this->rejected($applicantt, $programme_code);
        }              
    }

    public function ial($applicantt) //A Level Programme
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();
        
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }
        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_eng = array_keys(array_column($olevel->toArray(), 'subject'), 1123);
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 4037);
        $count_math_d = array_keys(array_column($olevel->toArray(), 'subject'), 4024);
        if($count_eng != []  && ($count_math_a != [] || $count_math_d != []))
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 3.00)
                    {
                        $creditolevel = 0;
                    }else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;
                }
                if($total_creditolevel >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        
        if(in_array(true, $status))
        {
            $programme_code = 2;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 2;
            $this->rejected($applicantt, $programme_code);
        }
                
    }

    public function igr($applicantt) //A Level German Programme
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();
        
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }
        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_eng = array_keys(array_column($olevel->toArray(), 'subject'), 1123);
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 4037);
        $count_math_d = array_keys(array_column($olevel->toArray(), 'subject'), 4024);
        if($count_eng != []  && ($count_math_a != [] || $count_math_d != []))
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 3.00)
                    {
                        $creditolevel = 0;
                    }else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;
                }
                if($total_creditolevel >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        
        if(in_array(true, $status))
        {
            $programme_code = 3;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 3;
            $this->rejected($applicantt, $programme_code);
        }
                
    }

    public function iam($applicantt) //SACE International
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();
        
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }
        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_eng = array_keys(array_column($olevel->toArray(), 'subject'), 1123);
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 4037);
        $count_math_d = array_keys(array_column($olevel->toArray(), 'subject'), 4024);
        if($count_eng != []  && ($count_math_a != [] || $count_math_d != []))
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 3.00)
                    {
                        $creditolevel = 0;
                    }else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;
                }
                if($total_creditolevel >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        
        
        if(in_array(true, $status))
        {
            $programme_code = 4;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 4;
            $this->rejected($applicantt, $programme_code);
        }                  
    }

    public function ile($applicantt) //Japanese Preparatory Course
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();

        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_bio = array_keys(array_column($spm->toArray(), 'subject'), 4551);
        $count_chem = array_keys(array_column($spm->toArray(), 'subject'), 4541);
        $count_phy = array_keys(array_column($spm->toArray(), 'subject'), 4531);
        $count_sci = array_keys(array_column($spm->toArray(), 'subject'), 1511);
        if($count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] >= 9)
                    {
                        $creditspm = 1;
                    }else
                    {
                        $creditspm = 0;
                    }
                    $total_creditspm += $creditspm;
                    if($count_bio != [] || $count_chem != [] || $count_phy != [])
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                    if($count_sci != [] )
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 5;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 5;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function ikr($applicantt) //Korean Preparatory Course
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',1)->get();

        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        if($count_eng != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] >= 9)
                    {
                        $creditspm = 1;
                    }else
                    {
                        $creditspm = 0;
                    }
                    $total_creditspm += $creditspm;
                    if($count_eng != [])
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 6;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 6;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function dbm($applicantt) //Diploma in Business Management
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = ApplicantResult::where('applicant_id', $applicantt['id'])->where('type',1)->get();

        if($spm->count() > 0)
        {
            $total_creditspm = 0;
            foreach($spm->toArray() as $spmcredit)
            {
                if($spmcredit['grade'] < 9)
                {
                    $creditspm = 0;
                } else
                {
                    $creditspm = 1;
                }
                $total_creditspm += $creditspm;

            }
            if($total_creditspm >= 3)
            {
                $status[] = true;
            } else
            {
                $status[] = false;
            }
        }

        $stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->get();
        if($stpm->count() > 0)
        {
            $total_creditstpm = 0;
            foreach($stpm->toArray() as $stpmcredit)
            {
                if($stpmcredit['grade'] < 2.00)
                {
                    $creditstpm = 0;
                } else
                {
                    $creditstpm = 1;
                }
                $total_creditstpm += $creditstpm;

            }
            if($total_creditstpm >= 1)
            {
                $status[] = true;
            } else
            {
                $status[] = false;
            }
        }

        $uec = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',4)->get();
        if($uec->count() > 0)
        {
            $total_credituec = 0;
            foreach($uec->toArray() as $ueccredit)
            {
                if($ueccredit['grade'] < 2.00)
                {
                    $credituec = 0;
                }else
                {
                    $credituec = 1;
                }
                $total_credituec += $credituec;
                if($total_credituec >= 3)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        if($olevel->count() > 0)
        {
            $total_creditolevel = 0;
            foreach($olevel->toArray() as $olevelcredit)
            {
                if($olevelcredit['grade'] < 3.00)
                {
                    $creditolevel = 0;
                }else
                {
                    $creditolevel = 1;
                }
                $total_creditolevel += $creditolevel;
                if($total_creditolevel >= 3)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $mqf = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->get();
        if($mqf->count() > 0)
        {
            $mqf = $mqf->toArray();
            $cgpaarray = array_column($mqf,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 2.00)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->get();
        if($count_math != [] && $count_eng != [])
        {
            if($skm->count() > 0)
            {
                $total_creditskm = 0;
                foreach($skm->toArray() as $skmcredit)
                {
                    if($spm->count() > 0)
                    {
                        $total_creditskm = 0;
                        foreach($spm->toArray() as $spmcredit)
                        {
                            if($spmcredit['grade'] < 9)
                            {
                                $creditskm = 0;
                            } else
                            {
                                $creditskm = 1;
                            }
                            $total_creditskm += $creditskm;
                        }
                        if($total_creditspm >= 1)
                        {
                            $status[] = true;
                        }else
                        {
                            $status[] = false;
                        }
                    }
                }
            }
        }

        $komuniti = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',18)->get();
        if($komuniti->count() > 0)
        {
            $total_creditkom = 0;
            foreach($komuniti->toArray() as $komcredit)
            {
                if($spm->count() > 0)
                {
                    $total_creditkom = 0;
                    foreach($spm->toArray() as $spmcredit)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditkom = 0;
                        } else
                        {
                            $creditkom = 1;
                        }
                        $total_creditkom += $creditkom;
                    }
                    if($total_creditkom >= 1)
                    {
                        $status[] = true;
                    }else
                    {
                        $status[] = false;
                    }
                }
            }        
        }
        if(in_array(true, $status))
        {
            $programme_code = 7;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 7;
            $this->rejected($applicantt, $programme_code);
        }            
    }

    public function dpmg($applicantt) //Diploma in Public Management and Governance
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        if($spm->count() > 0)
        {
            $total_creditspm = 0;
            foreach($spm->toArray() as $spmcredit)
            {
                if($spmcredit['grade'] < 9)
                {
                    $creditspm = 0;
                    break;
                }else
                {
                    $creditspm = 1;
                }
                $total_creditspm += $creditspm;
            }
            if($total_creditspm >= 3)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }
        
        $stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->get();
        if($stpm->count() > 0)
        {
            $total_creditstpm = 0;
            foreach($stpm->toArray() as $stpmcredit)
            {
                if($stpmcredit['grade'] < 2.00)
                {
                    $creditstpm = 0;
                    break;
                }else
                {
                    $creditstpm = 1;
                }
                $total_creditstpm += $creditstpm;
            }
            if($total_creditstpm >= 1)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $stam = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',3)->get();
        if($stam->count() > 0)
        {
            $total_creditstam = 0;
            foreach($stam->toArray() as $stamcredit)
            {
                if($stamcredit['grade'] == 0.00)
                {
                    $creditstam = 0;
                    break;
                }else
                {
                    $creditstam = 1;
                }
                $total_creditstam += $creditstam;
            }
            if($total_creditstam >= $stam->count())
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        if($olevel->count() > 0)
        {
            $total_creditolevel = 0;
            foreach($olevel->toArray() as $olevelcredit)
            {
                if($olevelcredit['grade'] < 3.00)
                {
                    $creditolevel = 0;
                }else
                {
                    $creditolevel = 1;
                }
                $total_creditolevel += $creditolevel;
            }
            if($total_creditolevel >= 3)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $uec = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',4)->get();
        if($uec->count() > 0)
        {
            $total_credituec = 0;
            foreach($uec->toArray() as $ueccredit)
            {
                if($ueccredit['grade'] < 2.00)
                {
                    $credituec = 0;
                }else
                {
                    $credituec = 1;
                }
                $total_credituec += $credituec;
            }
            if($total_credituec >= 3)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $mqf = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',14)->get();
        if($mqf->count() > 0)
        {
            $mqf = $mqf->toArray();
            $cgpaarray = array_column($mqf,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 2.00)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->get();
        if($skm->count() > 0)
        {
            $total_creditskm = 0;
            foreach($skm->toArray() as $skmcredit)
            {
                if($spm->count() > 0)
                {
                    $total_creditskm = 0;
                    foreach($spm->toArray() as $spmcredit)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditskm = 0;
                        } else
                        {
                            $creditskm = 1;
                        }
                        $total_creditskm += $creditskm;
                    }
                    if($total_creditspm >= 1)
                    {
                        $status[] = true;
                    }else
                    {
                        $status[] = false;
                    }
                }
            }        
        }

        $komuniti = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',18)->get();
        if($komuniti->count() > 0)
        {
            $total_creditkom = 0;
            foreach($koumniti->toArray() as $komcredit)
            {
                if($spm->count() > 0)
                {
                    $total_creditkom = 0;
                    foreach($spm->toArray() as $spmcredit)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditkom = 0;
                        } else
                        {
                            $creditkom = 1;
                        }
                        $total_creditkom += $creditkom;
                    }
                    if($total_creditspm >= 1)
                    {
                        $status[] = true;
                    }else
                    {
                        $status[] = false;
                    }
                }
            }        
        }
        if(in_array(true, $status))
        {
            $programme_code = 8;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 8;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function dshp($applicantt) //Diploma in Scientific Halal Practice
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $count_bio = array_keys(array_column($spm->toArray(), 'subject'), 4551);
        $count_chemistry = array_keys(array_column($spm->toArray(), 'subject'), 4541);
        $count_agama = array_keys(array_column($spm->toArray(), 'subject'), 1223);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_english = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_melayu = array_keys(array_column($spm->toArray(), 'subject'), 1103);
        $count_sejarah = array_keys(array_column($spm->toArray(), 'subject'), 1249);
        $count_syariah = array_keys(array_column($spm->toArray(), 'subject'), 5228);
        $count_science = array_keys(array_column($spm->toArray(), 'subject'), 1511);
        if($count_math != [] && $count_english != [] && $count_melayu != [] && $count_sejarah)
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1103 && $spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1249)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }

                    if(($count_agama != [] || $count_syariah != []) && $count_bio != [] && $count_chemistry != [])
                    {
                        if($spmcredit['subject'] == 4551 && $spmcredit['subject'] == 4541)
                        {
                            if($spmcredit['grade'] < 9)
                            {
                                $total_creditspm = 0;
                                break;
                            }
                        }
                    }

                    if(($count_agama != [] || $count_syariah != []) && $count_science != [])
                    {
                        if($spmcredit['subject'] == 4551 && $spmcredit['subject'] == 1511)
                        {
                            if($spmcredit['grade'] < 12)
                            {
                                $total_creditspm = 0;
                                break;
                            }
                        }
                    }

                }
                if($total_creditspm >= $spm->count())
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        $stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->get();
        $count_math_m = array_keys(array_column($stpm->toArray(), 'subject'), 950);
        $count_math_t = array_keys(array_column($stpm->toArray(), 'subject'), 954);
        $count_bio = array_keys(array_column($stpm->toArray(), 'subject'), 964);
        $count_chemistry = array_keys(array_column($stpm->toArray(), 'subject'), 962);
        if(($count_math_m != [] || $count_math_t != [] )&& $count_bio != [] && $count_eng != [])
        {
            if($stpm->count() > 0)
            {
                $total_creditstpm = 0;
                foreach($stpm->toArray() as $stpmcredit)
                {
                    if($stpmcredit['grade'] < 9)
                    {
                        $creditstpm = 0;
                    } else
                    {
                        $creditstpm = 1;
                    }

                    $total_creditstpm += $creditstpm;

                    if($stpmcredit['subject'] == 950 || $stpmcredit['subject'] == 954)
                    {
                        if($stpmcredit['grade'] < 9)
                        {
                            $total_creditstpm = 0;
                            break;
                        }else
                        {
                            $creditstpm = 1;
                        }
                    }
                    if($stpmcredit['subject'] == 964 && $stpmcredit['subject'] == 962)
                    {
                        if($stpmcredit['grade'] < 9)
                        {
                            $total_creditstpm = 0;
                            break;
                        }else
                        {
                            $creditstpm = 1;
                        }
                    }
                }
                if($total_creditstpm >= $stpm->count())
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        $alevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',5)->get();
        $count_bio = array_keys(array_column($alevel->toArray(), 'subject'), 'A101');
        $count_chemistry = array_keys(array_column($alevel->toArray(), 'subject'), 'A102');
        if($count_bio != [] && $count_chemistry != [])
        {
            if($alevel->count() > 0)
            {
                $total_creditalevel = 0;
                foreach($alevel->toArray() as $alevelcredit)
                {
                    if($alevelcredit['grade'] < 3.00)
                    {
                        $creditalevel = 0;
                    }else
                    {
                        $creditalevel = 1;
                    }

                    $total_creditalevel += $creditalevel;

                    if($alevelcredit['subject'] == 'A101' && $alevelcredit['subject'] == 'A102')
                    {
                        if($alevelcredit['grade'] < 3.00)
                        {
                            $total_creditalevel = 0;
                            break;
                        }else
                        {
                            $creditalevel = 1;
                        }
                    }
                }
                if($total_creditalevel >= $alevel->count())
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        $sace = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',10)->get();
        if($sace->count() > 0)
        {
            $sace = $sace->toArray();
            $sacearray = array_column($sace, 'cgpa');
            foreach($sacearray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 50)
            {
                $status[] = true;
            } else
            {
                $status[] = false;
            }
        }

        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_bio = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE5090');
        $count_chemistry = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE5070');
        $count_science = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE5129');
        $count_english = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE1119');
        $count_math = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE4024');
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 'CIE4937');
        if(($count_bio != [] || $count_chemistry != [] || $count_science != []) && $count_english != [] && ($count_math != [] || $count_math_a))
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 3.00)
                    {
                        $creditolevel = 0;
                    }else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;
                    if((($olevelcredit['subject'] == 'CIE4024' || $olevelcredit['subject'] == 'CIE4937') && $olevelcredit['subject'] == 'CIE1119') && $olevelcredit['subject'] == 'CIE5090' || $olevelcredit['subject'] == 'CIE5070' || $olevelcredit['subject'] == 'CIE5129')
                    {
                        if($olevelcredit['grade'] < 3.00)
                        {
                            $total_creditolevel = 0;
                            break;
                        }else
                        {
                            $creditolevel = 1;
                        }
                    }
                }
                if($total_creditolevel >= $olevel->count())
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        if(in_array(true, $status))
        {
            $programme_code = 9;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 9;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function dia($applicantt) //Diploma in Accounting
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        if($count_math != [] && $count_eng != [])
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;
                    if($spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1119)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditspm = 0;
                            break;
                        }
                        else
                        {
                            $creditspm = 1;
                        }
                    }
                }
                if($total_creditspm >= 5)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        if($count_math != [] && $count_eng != [])
        {
            if($stpm->count() > 0)
            {
                $total_creditstpm = 0;
                foreach($stpm->toArray() as $stpmcredit)
                {
                    if($stpmcredit['grade'] < 9)
                    {
                        $creditstpm = 0;
                        break;
                    }else
                    {
                        $creditstpm = 1;
                    }
                    $total_creditstpm += $creditstpm;
                    if($spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1119)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditspm = 0;
                            break;
                        }
                        else
                        {
                            $creditspm = 1;
                        }
                    }
                }
                if($total_creditstpm >= $stpm->count())
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $stam = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',3)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        if($count_math != [] && $count_eng != [])
        {
            if($stam->count() > 0)
            {
                $total_creditstam = 0;
                foreach($stam->toArray() as $stamcredit)
                {
                    if($stamcredit['grade'] == 0.00)
                    {
                        $creditstam = 0;
                        break;
                    }else
                    {
                        $creditstam = 1;
                    }
                    $total_creditstam += $creditstam;
                    if($spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1119)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditspm = 0;
                            break;
                        }
                        else
                        {
                            $creditspm = 1;
                        }
                    }
                }
                if($total_creditstam >= $stam->count())
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        if($count_math != [] && $count_eng != [])
        {
            if($skm->count() > 0)
            {
                $total_creditskm = 0;
                foreach($skm->toArray() as $skmcredit)
                {
                        if($spm->count() > 0)
                        {
                            $total_creditskm = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] < 9)
                                {
                                    $creditskm = 0;
                                } else
                                {
                                    $creditskm = 1;
                                }
                                $total_creditskm += $creditskm;

                                if($spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1119)
                                {
                                    if($spmcredit['grade'] < 9)
                                    {
                                        $creditskm = 0;
                                        break;
                                    }
                                    else
                                    {
                                        $creditskm = 1;
                                    }
                                }
                            }
                            if($total_creditspm >= 1)
                            {
                                $status[] = true;
                            }else
                            {
                                $status[] = false;
                            }
                        }
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 10;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 10;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function dif($applicantt) //Diploma in Islamic Finance
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_math != [] )
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
                if($total_creditspm >= $spm->count())
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        $stpm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',2)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        $count_mathstpm_m = array_keys(array_column($stpm->toArray(), 'subject'), 950);
        $count_mathstpm_t = array_keys(array_column($stpm->toArray(), 'subject'), 954);
        if($count_math != [] && ($count_mathstpm_m != [] || $count_mathstpm_t != []))
        {
            if($stpm->count() > 0)
            {
                $total_creditstpm = 0;
                foreach($stpm->toArray() as $stpmcredit)
                {
                    if($stpmcredit['grade'] < 9)
                    {
                        $creditstpm = 0;
                    }else
                    {
                        if($stpmcredit['subject'] == 950 || $stpmcredit['subject'] == 954)
                        {
                            if($stpmcredit['grade'] < 9)
                            {
                                $creditstpm = 0;
                            }
                            else
                            {
                                $creditstpm = 1;
                            }
                        }
                    }
                    $total_creditstpm += $creditstpm;
                    if($spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $creditstpm = 0;
                        }
                        else
                        {
                            $creditstpm = 1;
                        }
                    }
                }
                if($total_creditstpm >= $stpm->count())
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $stam = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',3)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_math != [])
        {
            if($stam->count() > 0)
            {
                $total_creditstam = 0;
                foreach($stam->toArray() as $stamcredit)
                {
                    if($spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditstam = 0;
                            break;
                        }
                        else
                        {
                            $creditstam = 1;
                            if($stamcredit['grade'] == 0.00)
                            {
                                $creditstam = 0;
                            }else
                            {
                                $creditstam = 1;
                            }
                        }
                    }
                    $total_creditstam += $creditstam;
                }
                if($total_creditstam >= $stam->count())
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $olevel = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',6)->get();
        $count_math_a = array_keys(array_column($olevel->toArray(), 'subject'), 135);
        $count_math_d = array_keys(array_column($olevel->toArray(), 'subject'), 136);
        if($count_math_a != [] || $count_math_d != [])
        {
            if($olevel->count() > 0)
            {
                $total_creditolevel = 0;
                foreach($olevel->toArray() as $olevelcredit)
                {
                    if($olevelcredit['grade'] < 9)
                    {
                        $creditolevel = 0;
                    } else
                    {
                        $creditolevel = 1;
                    }
                    $total_creditolevel += $creditolevel;

                    if($olevelcredit['subject'] == 135 || $olecelcredit['subject'] == 136)
                    {
                        if($olevelcredit['grade'] < 3.00)
                        {
                            $creditolevel = 0;
                            break;
                        }
                        else
                        {
                            $creditolevel = 1;
                        }
                    }
                }
                if($total_creditolevel >= 3)
                {
                    $status[] = true;
                } else
                {
                    $status[] = false;
                }
            }
        }

        $uec = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',4)->get();
        $count_math = array_keys(array_column($uec->toArray(), 'subject'), 'UEC104');
        if($count_math != [])
        {
            if($uec->count() > 0)
            {
                $total_credituec = 0;
                foreach($uec->toArray() as $ueccredit)
                {
                    if($ueccredit['grade'] < 2.33)
                    {
                        $credituec = 0;
                    }else
                    {
                        $credituec = 1;
                    }
                    $total_credituec += $credituec;

                    if($ueccredit['subject'] == 'UEC104')
                    {
                        if($ueccredit['grade'] >= 2.33)
                        {
                            $credituec = 0;
                            break;
                        }else
                        {
                            $credituec = 1;
                        }                                    
                    }
                }
                if($total_credituec >= 3)
                {
                    $status[] = true;
                }else
                {
                    $status[] = false;
                }
            }
        }

        $skm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',7)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_math != [])
        {
            if($skm->count() > 0)
            {
                $total_creditskm = 0;
                foreach($skm->toArray() as $skmcredit)
                {
                        if($spm->count() > 0)
                        {
                            $total_creditskm = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] < 9)
                                {
                                    $creditskm = 0;
                                } else
                                {
                                    $creditskm = 1;
                                }
                                $total_creditskm += $creditskm;

                                if($spmcredit['subject'] == 1449)
                                {
                                    if($spmcredit['grade'] < 9)
                                    {
                                        $creditskm = 0;
                                        break;
                                    }
                                    else
                                    {
                                        $creditskm = 1;
                                    }
                                }
                            }
                            if($total_creditspm >= 1)
                            {
                                $status[] = true;
                            }else
                            {
                                $status[] = false;
                            }
                        }
                }
            }
        }

        $komuniti = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',18)->get();
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_math != [])
        {
            if($komuniti->count() > 0)
            {
                $total_creditkom = 0;
                foreach($komuniti->toArray() as $komcredit)
                {
                        if($spm->count() > 0)
                        {
                            $total_creditkom = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] < 9)
                                {
                                    $creditkom = 0;
                                } else
                                {
                                    $creditkom = 1;
                                }
                                $total_creditkom += $creditkom;

                                if($spmcredit['subject'] == 1449)
                                {
                                    if($spmcredit['grade'] < 9)
                                    {
                                        $creditkom = 0;
                                        break;
                                    }
                                    else
                                    {
                                        $creditkom = 1;
                                    }
                                }
                            }
                            if($total_creditkom >= 1)
                            {
                                $status[] = true;
                            }else
                            {
                                $status[] = false;
                            }
                        }
                }
            }
        }

        $kkm = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',15)->get();
        if($kkm->count() > 0)
        {
            $kkm = $kkm->toArray();
            $cgpaarray = array_column($kkm,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 2.00)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        if(in_array(true, $status))
        {
            $programme_code = 11;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 11;
            $this->rejected($applicantt, $programme_code);
        }         
    }

    public function cat($applicantt) //Certified Accounting Technician
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_malay = array_keys(array_column($spm->toArray(), 'subject'), 1103);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] && $count_malay != [])
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1103 && $spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 12;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 12;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function cfab($applicantt) //Certified in Accounting, Finance & Business
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
        $count_malay = array_keys(array_column($spm->toArray(), 'subject'), 1103);
        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
        if($count_eng != []  && $count_math != [] && $count_malay != [])
        {
            if($spm->count() > 0)
            {
                $total_creditspm = 0;
                foreach($spm->toArray() as $spmcredit)
                {
                    if($spmcredit['grade'] < 9)
                    {
                        $creditspm = 0;
                    } else
                    {
                        $creditspm = 1;
                    }
                    $total_creditspm += $creditspm;

                    if($spmcredit['subject'] == 1103 && $spmcredit['subject'] == 1119 && $spmcredit['subject'] == 1449)
                    {
                        if($spmcredit['grade'] < 9)
                        {
                            $total_creditspm = 0;
                            break;
                        }
                    }
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 13;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 13;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function micpa($applicantt) //The Malaysian Institute of Certified Public Accountants
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->get();
        if($bachelors->count() > 0)
        {
            $bachelors = $bachelors->toArray();
            $cgpaarray = array_column($bachelors,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 2.50)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 14;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 14;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function acca($applicantt) //The Association of Chartered Certified Accountants
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->get();
        if($muet->count() > 0)
        {
            $muet = $muet->toArray();
            $cgpaarray = array_column($muet,'cgpa');
            foreach($cgpaarray as $muets)
            {
                $muet = $muets;
                if($muets >= 2)
                {
                    $matriculations = ApplicantResult::where('applicant_id',$applicantt['id'])-get();
                    foreach($matriculations as $matriculation)
                    {
                        if($matriculation['type'] == 12 || $matriculation['type'] == 13)
                        {
                            if($matriculation['cgpa'] >= 2.50)
                            {
                                $count_math = array_keys(array_column($spm->toArray(), 'subject'), 1449);
                                $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 1119);
                                if($count_math != [] && $count_eng != [])
                                {
                                    if($spm->count() > 0)
                                    {
                                        $total_creditspm = 0;
                                        foreach($spm->toArray() as $spmcredit)
                                        {
                                            if($spmcredit['subject'] == 1449 && $spmcredit['subject'] == 1119)
                                            {
                                                if($spmcredit['grade'] < 9)
                                                {
                                                    $creditspm = 0;
                                                    break;
                                                }else
                                                {
                                                    $creditspm = 1;
                                                }
                                            }
                                            $total_creditspm += $creditspm;
                                            if($total_creditspm = 2)
                                            {
                                                $status[] = true;
                                            }else
                                            {
                                                $status[] = false;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $diploma = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',8)->get();
                    if($diploma->count() > 0)
                    {
                        $diploma = $diploma->toArray();
                        $cgpaarray = array_column($diploma,'cgpa');
                        foreach($cgpaarray as $cgp)
                        {
                            $cgpa = $cgp;
                        }
                        if($cgpa >= 3.00)
                        {
                            $status[] = true;
                        }else
                        {
                            $status[] = false;
                        }
                    }

                    $cat = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',16)->get();
                    if($cat->count() > 0)
                    {
                        $cat = $cat->toArray();
                        $cgpaarray = array_column($cat,'cgpa');
                        foreach($cgpaarray as $cgp)
                        {
                            $cgpa = $cgp;
                        }
                        if($cgpa == 'Pass')
                        {
                            $status[] = true;
                        }else
                        {
                            $status[] = false;
                        }
                    }

                    $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->get();
                    if($bachelors->count() > 0)
                    {
                        $bachelors = $bachelors->toArray();
                        $cgpaarray = array_column($bachelors,'cgpa');
                        foreach($cgpaarray as $cgp)
                        {
                            $cgpa = $cgp;
                        }
                        if($cgpa >= 2.50)
                        {
                            $status[] = true;
                        }else
                        {
                            $status[] = false;
                        }
                    }
                }
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 15;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 15;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function aca($applicantt) //Association of Chartered Accountants (ACA) for Institute of Chartered Accountants in England and Wales (ICAEW)
    {
        $status = [];
        $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
        $spm = $applicantresultt->where('type',1)->get();

        $bachelors = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',9)->get();
        if($bachelors->count() > 0)
        {
            $bachelors = $bachelors->toArray();
            $cgpaarray = array_column($bachelors,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa >= 2.75)
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }

        $icaew = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',17)->get();
        if($bachelors->count() > 0)
        {
            $icaew = $icaew->toArray();
            $cgpaarray = array_column($icaew,'cgpa');
            foreach($cgpaarray as $cgp)
            {
                $cgpa = $cgp;
            }
            if($cgpa == 'Pass')
            {
                $status[] = true;
            }else
            {
                $status[] = false;
            }
        }
        if(in_array(true, $status))
        {
            $programme_code = 16;
            $this->accepted($applicantt, $programme_code);
        } else {
            $programme_code = 16;
            $this->rejected($applicantt, $programme_code);
        }        
    }

    public function checkrequirements()
    {
        $applicant = Applicant::where('applicant_status', NULL)->select('*')->get();
        $applicantresult = ApplicantResult::all();

        $result = [];
        $applicants = Applicant::where('applicant_status', NULL)->get()->toArray();
        foreach ($applicants as $applicantt)
        {
            $p = $applicantt['applicant_programme'];
            $p2 = $applicantt['applicant_programme_2'];
            $p3 = $applicantt['applicant_programme_3'];
            $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
            $spm = $applicantresultt->where('type',1)->get();

            $status = [];
            if($p == 1 || $p2 == 1 || $p3 == 1)
            {
                $this->iat($applicantt);
            }
            if($p == 2 || $p2 == 2 || $p3 == 2)
            {
                $this->ial($applicantt);
            }

            if($p == 3 || $p2 == 3 || $p3 == 3)
            {
                $this->igr($applicantt);
            }

            if($p == 4 || $p2 == 4 || $p3 == 4)
            {
                $this->iam($applicantt);
            }

            if($p == 5 || $p2 == 5 || $p3 == 5)
            {
                $this->ile($applicantt);
            }
            
            if($p == 6 || $p2 == 6 || $p3 == 6)
            {
                $this->ikr($applicantt);
            }

            if($p == 7 || $p2 == 7 || $p3 == 7)
            {
                $this->dbm($applicantt);
            }

            if($p == 8 || $p2 == 8 || $p3 == 8)
            {
                $this->dpmg($applicantt);
            }

            if($p == 9 || $p2 == 9 || $p3 == 9)
            {
                $this->dshp($applicantt);
            }

            if($p == 10 || $p2 == 10 || $p3 == 10)
            {
                $this->dia($applicantt);
            }

            if($p == 11 || $p2 == 11 || $p3 == 11)
            {
                $this->dif($applicantt);
            }

            if($p == 12 || $p2 == 12 || $p3 == 12)
            {
                $this->cat($applicantt);
            }

            if($p == 13 || $p2 == 13 || $p3 == 13)
            {
                $this->cfab($applicantt);
            }
            
            if($p == 14 || $p2 == 14 || $p3 == 14)
            {
                $this->micpa($applicantt);
            }

            if($p == 15 || $p2 == 15 || $p3 == 15)
            {
                $this->acca($applicantt);
            }

            if($p == 16 || $p2 == 16 || $p3 == 16)
            {
                $this->aca($applicantt);
            }
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
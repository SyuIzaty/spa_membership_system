<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\ApplicantResult;
use App\ApplicantStatus;
use App\Programme;
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


    public function accepted(){
        $applicantstatus = ApplicantStatus::where('applicant_status','Selected')->get();
        $applicants = [];
        foreach($applicantstatus as $applicantstat)
        {
            $applicant[] = Applicant::where('id',$applicantstat->applicant_id)->first();
        }
        $applicants = $applicant;
        return view('applicant.applicantresult', compact('applicants'));
    }

    public function rejected(){
        $applicant = Applicant::where('applicant_status','Rejected')->get();
        return view('applicant.rejected', compact('applicant'));
    }

    public function addprogrammestatus($result)
    {
        $array = $this->unique_multidim_array($result,'id');
        foreach ($array as $id)
        {
            $status = [];
            foreach($result as $results)
            {
                if(in_array($id['id'], $results))
                {
                    $status[] = $results['status'];
                }
            }
            $statuss = implode(',',$status);
            $programme_status = Applicant::where('id',$id['id'])->first();
            if($programme_status)
            {
                $programme_status->programme_status = $statuss;
                $programme_status->save();
            }
        }
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
       
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function indexs()
    {
        $programme = [];
        $applicant = Applicant::where('applicant_status',NULL)->get()->toArray();

        foreach($applicant as $applicantstat)
        {
            $pro = explode(',',$applicantstat['applicant_programme']);
            $programme = [];
            foreach($pro as $programme_all)
            {
                $programme['programme'][] = Programme::where('id',$programme_all)->first();
            }          
            $dataappl[] = array_merge($applicantstat, $programme);  
        }

        $aapplicant = $dataappl;
        return view('applicant.applicantresult', compact('aapplicant'));
    }

    public function checkrequirements()
    {
        $applicant = Applicant::where('applicant_status', NULL)->select('*')->get();
        $applicantresult = ApplicantResult::all();

        $result = [];
        $applicants = Applicant::where('applicant_status', NULL)->get()->toArray();
        foreach ($applicants as $applicantt)
        {
            $program = explode(',',$applicantt['applicant_programme']);
            foreach($program as $programm)
            {
                $p = $programm;
                $applicantresultt = ApplicantResult::where('applicant_id',$applicantt['id']);
                $spm = $applicantresultt->where('type',1)->get();

                $status = [];
                if($p == 1 || $p == 2 || $p == 3 || $p == 4)
                {
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    if($count_eng != []  && $count_math != [] )
                    {
                        if($spm->count() > 0)
                    {
                        $total_creditspm = 0;
                        foreach($spm->toArray() as $spmcredit)
                        {
                            if($spmcredit['grade'] >= 9)
                            {
                                $creditspm = 0;
                            } else
                            {
                                $creditspm = 1;
                            }
                            $total_creditspm += $creditspm;

                            if($spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                            {
                                if($spmcredit['grade'] >= 9)
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
                    $count_eng = array_keys(array_column($olevel->toArray(), 'subject'), 2);
                    $count_math = array_keys(array_column($olevel->toArray(), 'subject'), 3);
                    if($count_eng != []  && $count_math != [])
                    {
                        if($olevel->count() > 0)
                        {
                            $total_creditolevel = 0;
                            foreach($olevel->toArray() as $olevelcredit)
                            {
                                if($olevelcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }
                
                if ($p == 5)
                {
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_bio = array_keys(array_column($spm->toArray(), 'subject'), 9);
                    $count_chem = array_keys(array_column($spm->toArray(), 'subject'), 10);
                    $count_phy = array_keys(array_column($spm->toArray(), 'subject'), 11);
                    $count_sci = array_keys(array_column($spm->toArray(), 'subject'), 8);
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
                                    if($spmcredit['grade'] >= 9)
                                    {
                                        $total_creditspm = 0;
                                        break;
                                    }
                                }
                                if($count_sci != [] )
                                {
                                    if($spmcredit['grade'] >= 9)
                                    {
                                        $total_creditspm = 0;
                                        break;
                                    }
                                }
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if ($p == 7)
                {
                    if($spm->count() > 0)
                    {
                        $total_creditspm = 0;
                        foreach($spm->toArray() as $spmcredit)
                        {
                            if($spmcredit['grade'] >= 9)
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
                            if($stpmcredit['grade'] >= 9)
                            {
                                $creditstpm = 0;
                            } else
                            {
                                $creditstpm = 1;
                            }
                            $total_creditstpm += $creditstpm;

                        }
                        if($total_creditstpm >= $stpm->count())
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
                            if($ueccredit['grade'] >= 23)
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
                            if($olevelcredit['grade'] >= 9)
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
                                            if($spmcredit['grade'] >= 9)
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
                                    if($spmcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if($p == 12 || $p == 13)
                {
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    $count_malay = array_keys(array_column($spm->toArray(), 'subject'), 1);
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    if($count_eng != []  && $count_math != [] && $count_malay != [])
                    {
                        if($spm->count() > 0)
                    {
                        $total_creditspm = 0;
                        foreach($spm->toArray() as $spmcredit)
                        {
                            if($spmcredit['grade'] >= 9)
                            {
                                $creditspm = 0;
                            } else
                            {
                                $creditspm = 1;
                            }
                            $total_creditspm += $creditspm;

                            if($spmcredit['subject'] == 1 && $spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                            {
                                if($spmcredit['grade'] >= 9)
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

                    if(in_array(true, $status))
                    {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if($p == 14)
                {
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

                if($p == 10)
                {
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    if($count_math != [] && $count_eng != [])
                    {
                        if($spm->count() > 0)
                        {
                            $total_creditspm = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] >= 9)
                                {
                                    $creditspm = 0;
                                } else
                                {
                                    $creditspm = 1;
                                }
                                $total_creditspm += $creditspm;
                                if($spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    if($count_math != [] && $count_eng != [])
                    {
                        if($stpm->count() > 0)
                        {
                            $total_creditstpm = 0;
                            foreach($stpm->toArray() as $stpmcredit)
                            {
                                if($stpmcredit['grade'] >= 9)
                                {
                                    $creditstpm = 0;
                                    break;
                                }else
                                {
                                    $creditstpm = 1;
                                }
                                $total_creditstpm += $creditstpm;
                                if($spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    if($count_math != [] && $count_eng != [])
                    {
                        if($stam->count() > 0)
                        {
                            $total_creditstam = 0;
                            foreach($stam->toArray() as $stamcredit)
                            {
                                if($stamcredit['grade'] == 16)
                                {
                                    $stamcredit = 0;
                                    break;
                                }else
                                {
                                    $stamcredit = 1;
                                }
                                $total_creditstam += $stamcredit;
                                if($spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
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
                                            if($spmcredit['grade'] >= 9)
                                            {
                                                $creditskm = 0;
                                            } else
                                            {
                                                $creditskm = 1;
                                            }
                                            $total_creditskm += $creditskm;

                                            if($spmcredit['subject'] == 2 && $spmcredit['subject'] == 3)
                                            {
                                                if($spmcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if($p == 11)
                {
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    if($count_math != [] )
                    {
                        if($spm->count() > 0)
                        {
                            $total_creditspm = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] >= 9)
                                {
                                    $creditspm = 0;
                                } else
                                {
                                    $creditspm = 1;
                                }
                                $total_creditspm += $creditspm;

                                if($spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_mathstpm = array_keys(array_column($stpm->toArray(), 'subject'), 3);
                    if($count_math != [] && $count_mathstpm != [])
                    {
                        if($stpm->count() > 0)
                        {
                            $total_creditstpm = 0;
                            foreach($stpm->toArray() as $stpmcredit)
                            {
                                if($stpmcredit['grade'] >= 9)
                                {
                                    $creditstpm = 0;
                                }else
                                {
                                    if($stpmcredit['subject'] == 3)
                                    {
                                        if($stpmcredit['grade'] >= 9)
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
                                if($spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    if($count_math != [])
                    {
                        if($stam->count() > 0)
                        {
                            $total_creditstam = 0;
                            foreach($stam->toArray() as $stamcredit)
                            {
                                if($spmcredit['subject'] == 3)
                                {
                                    if($spmcredit['grade'] >= 9)
                                    {
                                        $total_creditstam = 0;
                                        break;
                                    }
                                    else
                                    {
                                        $creditstam = 1;
                                        if($stamcredit['grade'] == 16)
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
                    $count_math = array_keys(array_column($olevel->toArray(), 'subject'), 3);
                    if($count_math != [])
                    {
                        if($olevel->count() > 0)
                        {
                            $total_creditolevel = 0;
                            foreach($olevel->toArray() as $olevelcredit)
                            {
                                if($olevelcredit['grade'] >= 9)
                                {
                                    $creditolevel = 0;
                                } else
                                {
                                    $creditolevel = 1;
                                }
                                $total_creditolevel += $creditolevel;

                                if($olevelcredit['subject'] == 3)
                                {
                                    if($olevelcredit['grade'] >= 9)
                                    {
                                        $creditolevel = 0;
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
                    $count_math = array_keys(array_column($uec->toArray(), 'subject'), 3);
                    if($count_math != [])
                    {
                        if($uec->count() > 0)
                        {
                            $total_credituec = 0;
                            foreach($uec->toArray() as $ueccredit)
                            {
                                if($ueccredit['grade'] >= 23)
                                {
                                    $credituec = 0;
                                }else
                                {
                                    $credituec = 1;
                                }
                                $total_credituec += $credituec;

                                if($ueccredit['subject'] == 3)
                                {
                                    if($ueccredit['grade'] >= 23)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
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
                                            if($spmcredit['grade'] >= 9)
                                            {
                                                $creditskm = 0;
                                            } else
                                            {
                                                $creditskm = 1;
                                            }
                                            $total_creditskm += $creditskm;

                                            if($spmcredit['subject'] == 3)
                                            {
                                                if($spmcredit['grade'] >= 9)
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
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
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
                                            if($spmcredit['grade'] >= 9)
                                            {
                                                $creditkom = 0;
                                            } else
                                            {
                                                $creditkom = 1;
                                            }
                                            $total_creditkom += $creditkom;

                                            if($spmcredit['subject'] == 3)
                                            {
                                                if($spmcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if ($p == 8)
                {
                    if($spm->count() > 0)
                    {
                        $total_creditspm = 0;
                        foreach($spm->toArray() as $spmcredit)
                        {
                            if($spmcredit['grade'] >= 9)
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
                            if($stpmcredit['grade'] >= 9)
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
                            if($stamcredit['grade'] == 16)
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
                            if($olevelcredit['grade'] >= 9)
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
                            if($ueccredit['grade'] >= 23)
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
                                    if($spmcredit['grade'] >= 9)
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
                                    if($spmcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                

                if ($p == 9)
                {
                    $count_bio = array_keys(array_column($spm->toArray(), 'subject'), 9);
                    $count_chemistry = array_keys(array_column($spm->toArray(), 'subject'), 10);
                    $count_agama = array_keys(array_column($spm->toArray(), 'subject'), 5);
                    $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                    $count_english = array_keys(array_column($spm->toArray(), 'subject'), 2);
                    $count_melayu = array_keys(array_column($spm->toArray(), 'subject'), 1);
                    $count_sejarah = array_keys(array_column($spm->toArray(), 'subject'), 4);
                    $count_syariah = array_keys(array_column($spm->toArray(), 'subject'), 15);
                    $count_science = array_keys(array_column($spm->toArray(), 'subject'), 8);
                    if($count_math != [] && $count_english != [] && $count_melayu != [] && $count_sejarah)
                    {
                        if($spm->count() > 0)
                        {
                            $total_creditspm = 0;
                            foreach($spm->toArray() as $spmcredit)
                            {
                                if($spmcredit['grade'] >= 9)
                                {
                                    $creditspm = 0;
                                } else
                                {
                                    $creditspm = 1;
                                }
                                $total_creditspm += $creditspm;

                                if($spmcredit['subject'] == 1 && $spmcredit['subject'] == 2 && $spmcredit['subject'] == 3 && $spmcredit['subject'] == 4)
                                {
                                    if($spmcredit['grade'] >= 9)
                                    {
                                        $total_creditspm = 0;
                                        break;
                                    }
                                }

                                if(($count_agama != [] || $count_syariah != []) && $count_bio != [] && $count_chemistry != [])
                                {
                                    if($spmcredit['subject'] == 9 && $spmcredit['subject'] == 10)
                                    {
                                        if($spmcredit['grade'] >= 9)
                                        {
                                            $total_creditspm = 0;
                                            break;
                                        }
                                    }
                                }

                                if(($count_agama != [] || $count_syariah != []) && $count_science != [])
                                {
                                    if($spmcredit['subject'] == 9 && $spmcredit['subject'] == 8)
                                    {
                                        if($spmcredit['grade'] >= 5)
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
                    $count_math = array_keys(array_column($stpm->toArray(), 'subject'), 3);
                    $count_english = array_keys(array_column($stpm->toArray(), 'subject'), 1);
                    $count_bio = array_keys(array_column($stpm->toArray(), 'subject'), 9);
                    $count_chemistry = array_keys(array_column($stpm->toArray(), 'subject'), 10);
                    if($count_math != [] && $count_english != [] && $count_bio != [] && $count_eng != [])
                    {
                        if($stpm->count() > 0)
                        {
                            $total_creditstpm = 0;
                            foreach($stpm->toArray() as $stpmcredit)
                            {
                                if($stpmcredit['grade'] >= 9)
                                {
                                    $creditstpm = 0;
                                } else
                                {
                                    $creditstpm = 1;
                                }

                                $total_creditstpm += $creditstpm;

                                if($stpmcredit['subject'] == 2 && $stpmcredit['subject'] == 3)
                                {
                                    if($stpmcredit['grade'] >= 9)
                                    {
                                        $total_creditstpm = 0;
                                        break;
                                    }else
                                    {
                                        $creditstpm = 1;
                                    }
                                }
                                if($stpmcredit['subject'] == 9 && $stpmcredit['subject'] == 10)
                                {
                                    if($stpmcredit['grade'] >= 9)
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
                    $count_bio = array_keys(array_column($alevel->toArray(), 'subject'), 9);
                    $count_chemistry = array_keys(array_column($alevel->toArray(), 'subject'), 10);
                    if($count_bio != [] && $count_chemistry != [])
                    {
                        if($alevel->count() > 0)
                        {
                            $total_creditalevel = 0;
                            foreach($alevel->toArray() as $alevelcredit)
                            {
                                if($alevelcredit['grade'] >= 9)
                                {
                                    $creditalevel = 0;
                                }else
                                {
                                    $creditalevel = 1;
                                }

                                $total_creditalevel += $creditalevel;

                                if($alevelcredit['subject'] == 9 && $alevelcredit['subject'] == 10)
                                {
                                    if($alevelcredit['grade'] >= 9)
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
                    $count_bio = array_keys(array_column($olevel->toArray(), 'subject'), 9);
                    $count_chemistry = array_keys(array_column($olevel->toArray(), 'subject'), 10);
                    $count_science = array_keys(array_column($olevel->toArray(), 'subject'), 8);
                    $count_english = array_keys(array_column($olevel->toArray(), 'subject'), 2);
                    $count_math = array_keys(array_column($olevel->toArray(), 'subject'), 3);
                    if(($count_bio != [] || $count_chemistry != [] || $count_science != []) && $count_english != [] && $count_math != [])
                    {
                        if($olevel->count() > 0)
                        {
                            $total_creditolevel = 0;
                            foreach($olevel->toArray() as $olevelcredit)
                            {
                                if($olevelcredit['grade'] >= 9)
                                {
                                    $creditolevel = 0;
                                }else
                                {
                                    $creditolevel = 1;
                                }
                                $total_creditolevel += $creditolevel;
                                if($olevelcredit['subject'] == 0 || $olevelcredit['subject'] == 10 || $olevelcredit['subject'] == 8)
                                {
                                    if($olevelcredit['grade'] >= 9)
                                    {
                                        $total_creditolevel = 0;
                                        break;
                                    }else
                                    {
                                        $creditolevel = 1;
                                    }
                                }
                                if($olevelcredit['subject'] == 2 && $olevelcredit['subject'] == 3)
                                {
                                    if($olevelcredit['grade'] >= 9)
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
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if($p == 15)
                {
                    $muet = ApplicantResult::where('applicant_id',$applicantt['id'])->where('type',11)->get();
                    if($muet->count() > 0)
                    {
                        $muet = $muet->toArray();
                        $cgpaarray = array_column($muet,'cgpa');
                        foreach($cgpaarray as $muets)
                        {
                            $muet = $muets;
                        }
                        if($muets >= 2)
                        {
                            $matriculations = ApplicantResult::where('applicant_id',$applicantt['id'])-get();
                            foreach($matriculations as $matriculation)
                            {
                                if($matriculation['type'] == 12 || $matriculation['type'] == 13)
                                {
                                    if($matriculation['cgpa'] >= 2.50)
                                    {
                                        $count_math = array_keys(array_column($spm->toArray(), 'subject'), 3);
                                        $count_eng = array_keys(array_column($spm->toArray(), 'subject'), 2);
                                        if($count_math != [] && $count_eng != [])
                                        {
                                            if($spm->count() > 0)
                                            {
                                                $total_creditspm = 0;
                                                foreach($spm->toArray() as $spmcredit)
                                                {
                                                    if($spmcredit['subject'] == 3 && $spmcredit['subject'] == 2)
                                                    {
                                                        if($spmcredit['grade'] >= 9)
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
                    
                    if(in_array(true, $status))
                    {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Accepted'];
                    } else {
                        $result[] = ['id'=>$applicantt['id'],'status'=>'Rejected'];
                    }
                }

                if($p == 16)
                {
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
                }
            }
            $this->addprogrammestatus($result);
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
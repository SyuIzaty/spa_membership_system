<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Mode;
use App\Course;
use App\Programme;
use App\StudyPlan;
use App\StudyPlanHeader;
use App\StudyPlanElective;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlanInfoRequest;

class StudyPlanController extends Controller
{
    public function studyList()
    {
        $program = Programme::orderBy('programme_name')->get();
        $mode = Mode::orderBy('mode_name')->get();

        return view('study-plan.plan_list', compact('program', 'mode'));
    }

    public function data_studyPlan_list() 
    {
        $std = StudyPlan::select('*');
        
        return datatables()::of($std)
        ->addColumn('action', function ($std) {

            return '<a href="/detailPlan/'.$std->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Plan Details</a>
                    <a href="/showPlan/'.$std->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/study-plan/plan_list/' . $std->id . '"><i class="fal fa-trash"></i>  Delete</button>';
        })

        ->editColumn('plan_progs', function ($std) {

            return strtoupper($std->programs->programme_name);
       })

        ->editColumn('plan_sm', function ($std) {

            return strtoupper($std->modes->mode_name);
       })

        ->editColumn('plan_stat', function ($std) {

            return strtoupper($std->plan_stat ? 'Active' : 'Inactive');
        })

        ->editColumn('created_at', function ($std) {

            return date(' Y-m-d | H:i A', strtotime($std->created_at) );
        })
        
        ->make(true);
    }

    public function createPlan(StorePlanInfoRequest $request)
    {
        $std = StudyPlan::where('id', $request->id)->first();

        StudyPlan::create([
                'plan_progs'        => $request->plan_progs,
                'plan_sm'           => $request->plan_sm, 
                // 'plan_cr_hr_total'  => $request->plan_cr_hr_total,
                'plan_cr_hr_total'  => 0,
                'plan_stat'         => $request->plan_stat,
                'plan_semester'     => $request->plan_semester,
            ]);
        
        return redirect('/studyPlan');
    }

    public function findCourseCr(Request $request)
    {
        $data = Course::select('credit_hours')
            ->where('id',$request->id)
            ->first();

        return response()->json($data);
    }

    public function updateDetail(StorePlanInfoRequest $request) 
    {
        $std = StudyPlan::where('id', $request->id)->first();

        $std->update([
            'plan_progs'        => $request->plan_progs,
            'plan_sm'           => $request->plan_sm, 
            'plan_stat'         => $request->plan_stat,
            'plan_semester'     => $request->plan_semester,
        ]);

        Session::flash('message', 'Details Updated Successfully');
        return redirect('detailPlan/'.$std->id);
    }

    public function createPlanHeader(Request $request)
    {
        $std = StudyPlan::where('id', $request->id)->first();

        // $course = Course::where('id', $request->id)->first();

        StudyPlanHeader::create([
                'std_plan_id'    => $std->id,  
                'std_hd_course'  => $request->std_hd_course,
                'std_hd_type'    => $request->std_hd_type,
                'std_hd_cr_hr'   => $request->std_hd_cr_hr,
            ]);
        
        return redirect('detailPlan/'.$std->id);
    }

    public function deletePlanHeader($id)
    {
        $exist = StudyPlanHeader::find($id);
        $exist->delete();
        return response()->json(['success', 'Successfully deleted!']);
    }

    public function detailPlan($id)
    {
        $std = StudyPlan::where('id', $id)->first(); 
        $stdHd = StudyPlanHeader::where('std_plan_id', $id)->get(); 

        // $total = DB::table('study_plans_header')->where('std_plan_id', $id)->sum('std_hd_cr_hr'); // db
        $total = StudyPlanHeader::where('std_plan_id', $id)->sum('std_hd_cr_hr');
        $std->update([
            'plan_cr_hr_total'     => $total,
        ]);
        // dd($total);

        $stdEl = StudyPlanElective::where('std_elec_hd_id', $id)->get(); 
        // dd($stdEl);
        $program = Programme::orderBy('programme_name')->get();
        $mode = Mode::orderBy('mode_name')->get();
        $planCourse = Course::orderBy('course_name')->get(); // !=

        return view('study-plan.plan_detail', compact('std', 'stdHd', 'program', 'mode', 'stdEl', 'planCourse', 'total'))->with('no', 1);
    }

    public function electiveInfo(Request $request)
    {
        //$std = StudyPlan::where('id', $request->std)->first();
        
        $stdHd = StudyPlanHeader::where('id', $request->hd)->first(); 
        // dd($stdHd);
        StudyPlanElective::where('std_elec_hd_id', $stdHd->id)->delete(); 
        
        foreach($request->std_elec_course as $value){ 
            $fields = [
                'std_elec_hd_id' => $stdHd->id,
                'std_elec_course' => $value
            ];

            StudyPlanElective::create($fields);
        }
        
        return redirect('detailPlan/'.$request->std);
    }

    public function showPlan($id)
    {
        $std = StudyPlan::where('id', $id)->first(); 
        $stdHd = StudyPlanHeader::where('std_plan_id', $id)->get(); 
        // dd($stdHd);
        $stdEl = StudyPlanElective::where('std_elec_hd_id', $id)->get(); 

        return view('study-plan.plan_show', compact('std', 'stdHd', 'stdEl'))->with('no', 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = StudyPlan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Study Plan deleted successfully.']);
    }
}

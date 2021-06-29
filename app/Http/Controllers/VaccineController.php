<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Staff;
use App\User;
use App\Vaccine;
use App\VaccineReason;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VaccineExport;

class VaccineController extends Controller
{

    public function form()
    {
        $user = Staff::where('staff_id', Auth::user()->id)->first();
        $reason = VaccineReason::all();
        $vaccine = Vaccine::where('user_id', Auth::user()->id)->first();
        
        return view('vaccine.form', compact('user','reason','vaccine'));
    }

    public function vaccineStore(Request $request)
    {
        $id = Auth::user();

        $validate = [
            'q1'              => 'required',
        ];

        if($request->q1 == 'Y') 
        {
            $validate['q2'] = 'required'; 
        } 
        if($request->q1 == 'N') 
        {
            $validate['q1_reason'] = 'required'; 
        } 
        if($request->q1_reason == '4') 
        {
            $validate['q1_other_reason'] = 'required'; 
        }
        if($request->q2 == 'Y') 
        {
            $validate['q3'] = 'required';  
        } 
        if($request->q3 == 'Y') 
        {
            $validate['q4'] = 'required';
            $validate['q3_date'] = 'required';
            $validate['q3_effect'] = 'required';
        }
        if($request->q4 == 'Y') 
        {
            $validate['q4_date'] = 'required';
            $validate['q4_effect'] = 'required';
        }
        if($request->q3_effect == 'Y') 
        {
            $validate['q3_effect_remark'] = 'required';
        }
        if($request->q4_effect == 'Y') 
        {
            $validate['q4_effect_remark'] = 'required';
        }

        $request->validate($validate);

        $vaccine = Vaccine::create([
            'user_id'           => $id->id,
            'q1'                => $request->q1,
            'q1_reason'         => $request->q1_reason,
            'q1_other_reason'   => $request->q1_other_reason, 
            'q2'                => $request->q2, 
            'q3'                => $request->q3,
            'q3_date'           => $request->q3_date,
            'q3_effect'         => $request->q3_effect, 
            'q3_effect_remark'  => $request->q3_effect_remark,
            'q4'                => $request->q4,
            'q4_date'           => $request->q4_date, 
            'q4_effect'         => $request->q4_effect,
            'q4_effect_remark'  => $request->q4_effect_remark,
        ]);
            
       Session::flash('message', 'Your Vaccine Detail Successfully Recorded');
       return redirect('/vaccineForm');
    }

    public function vaccineIndex()
    {    
        return view('vaccine.list');
    }

    public function data_vaccine()
    {
        $vaccine = Vaccine::all();

        return datatables()::of($vaccine)
        ->addColumn('action', function ($vaccine) {
            
            return '<a href="/vaccine-detail/' . $vaccine->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/deleteVaccine/' . $vaccine->id . '"><i class="fal fa-trash"></i></button>';
        })

        ->editColumn('created_at', function ($vaccine) {

            return strtoupper(date(' d/m/Y | h:i A', strtotime($vaccine->created_at) ));
        })

        ->editColumn('updated_at', function ($vaccine) {

            return strtoupper(date(' d/m/Y | h:i A', strtotime($vaccine->updated_at) ));
        })

        ->editColumn('user_name', function ($vaccine) {

            return strtoupper($vaccine->staffs->staff_name);
        })

        ->editColumn('user_position', function ($vaccine) {

            return strtoupper($vaccine->staffs->staff_position);
        })

        ->editColumn('user_depart', function ($vaccine) {

            return strtoupper($vaccine->staffs->staff_dept);
        })

        ->editColumn('q1', function ($vaccine) {

            return $vaccine->q1 ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q2', function ($vaccine) {

            return $vaccine->q2 ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q3', function ($vaccine) {

            return $vaccine->q3 ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q3_effect', function ($vaccine) {

            return $vaccine->q3_effect ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4', function ($vaccine) {

            return $vaccine->q4 ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('q4_effect', function ($vaccine) {

            return $vaccine->q4_effect ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('status', function ($vaccine) {

            if($vaccine->q4 == 'Y')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>COMPLETE</b></div>';
            }
            else 
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>IN PROCESS</b></div>';
            }
        })
        
        ->rawColumns(['action', 'q1', 'q2', 'q3', 'q3_effect', 'q4', 'q4_effect', 'created_at', 'updated_at', 'status', 'user_position', 'user_depart'])
        ->addIndexColumn()
        ->make(true);
    }

    public function exportVaccine()
    {
        return Excel::download(new VaccineExport,'Vaccine.xlsx');
    }

    public function vaccineDetail($id)
    {
        $vaccine = Vaccine::where('id', $id)->first();
        
        return view('vaccine.details', compact('vaccine'));
    }

    public function vaccineUpdate(Request $request)
    {
       $id = Auth::user();
        $vaccine = Vaccine::where('id', $request->id)->first();

        // radiobtn validation
        $validate = [
            'q1s'              => 'required',
        ];
        if($request->q1s == 'Y') 
        {
            $validate['q2s'] = 'required'; 
        } 
        if($request->q1s == 'N') 
        {
            $validate['q1_reasons'] = 'required'; 
        } 
        if($request->q1_reasons == '4') 
        {
            $validate['q1_other_reasons'] = 'required'; 
        }
        if($request->q2s == 'Y') 
        {
            $validate['q3s'] = 'required'; 
        } 
        if($request->q3s == 'Y') 
        {
            $validate['q4s'] = 'required';
            $validate['q3_dates'] = 'required';
            $validate['q3_effects'] = 'required';
        }
        if($request->q4s == 'Y') 
        {
            $validate['q4_dates'] = 'required';
            $validate['q4_effects'] = 'required';
        }
        if($request->q3_effects == 'Y') 
        {
            $validate['q3_effect_remarks'] = 'required';
        }
        if($request->q4_effects == 'Y') 
        {
            $validate['q4_effect_remarks'] = 'required';
        }

        $request->validate($validate);
         
        // onchange null

        if($request->q1s == 'Y')
        {
            if($request->q2s == 'Y')
            {
                if($request->q3s == 'Y')
                {
                    if($request->q4s == 'Y')
                    {
                        $vaccine->update([
                            'q1'                => $request->q1s, 
                            'q1_reason'         => null,
                            'q1_other_reason'   => null,
                            'q2'                => $request->q2s, 
                            'q3'                => $request->q3s, 
                            'q3_date'           => $request->q3_dates, 
                            'q3_effect'         => $request->q3_effects, 
                            'q3_effect_remark'  => $request->q3_effects ?  $request->q3_effect_remarks : null, 
                            'q4'                => $request->q4s, 
                            'q4_date'           => $request->q4_dates, 
                            'q4_effect'         => $request->q4_effects, 
                            'q4_effect_remark'  => $request->q4_effects ?  $request->q4_effect_remarks : null,
                        ]);
                    }
                    else
                    {
                        $vaccine->update([
                            'q1'                => $request->q1s, 
                            'q1_reason'         => null,
                            'q1_other_reason'   => null,
                            'q2'                => $request->q2s, 
                            'q3'                => $request->q3s, 
                            'q3_date'           => $request->q3_dates, 
                            'q3_effect'         => $request->q3_effects, 
                            'q3_effect_remark'  => $request->q3_effects ?  $request->q3_effect_remarks : null,
                            'q4'                => $request->q4s, 
                            'q4_date'           => $request->q4_dates, 
                        ]);
                    }  
                }
                else
                {
                    $vaccine->update([
                        'q1'                => $request->q1s, 
                        'q1_reason'         => null,
                        'q1_other_reason'   => null,
                        'q2'                => $request->q2s, 
                        'q3'                => $request->q3s, 
                        'q3_date'           => $request->q3_dates, 
                        'q3_effect'         => null, 
                        'q3_effect_remark'  => null, 
                        'q4'                => null, 
                        'q4_date'           => null, 
                        'q4_effect'         => null, 
                        'q4_effect_remark'  => null,
                    ]);
                }
            }
            else
            {
                $vaccine->update([
                    'q1'                => $request->q1s, 
                    'q1_reason'         => null,
                    'q1_other_reason'   => null,
                    'q2'                => $request->q2s, 
                    'q3'                => null, 
                    'q3_date'           => null, 
                    'q3_effect'         => null, 
                    'q3_effect_remark'  => null, 
                    'q4'                => null, 
                    'q4_date'           => null, 
                    'q4_effect'         => null, 
                    'q4_effect_remark'  => null,
                ]);
            }
        }
        else
        {
            $vaccine->update([
                'q1'                => $request->q1s, 
                'q1_reason'         => $request->q1_reasons,
                'q1_other_reason'   => $request->q1_other_reasons, 
            ]);
        }

       Session::flash('message', 'Your Vaccine Detail Successfully Recorded');
       return redirect('/vaccineForm');
    }

    public function deleteVaccine($id)
    {
        $exist = Vaccine::find($id);
        $exist->delete();

        return redirect('/vaccineIndex');
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
        //
    }
}

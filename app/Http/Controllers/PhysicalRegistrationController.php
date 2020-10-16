<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Applicant;
use App\Student;
use App\Intakes;
use App\User;
use DB;

class PhysicalRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('physical-registration.index');
    }

    public function data_newstudent()
    {
        $intake = Intakes::where('status','1')->first();
        $applicant = Applicant::where('intake_id',$intake['id'])->where('applicant_status','7A')->orWhere('applicant_status','3A')->get();

        return datatables()::of($applicant)
           ->addColumn('action', function ($applicant) {
               if($applicant['applicant_status'] == '3A'){
                    return '<button type="submit" class="btn btn-primary pull-right" name="check" value="'.$applicant->id.'">Register</button>';
               }
           })
           ->rawColumns(['action'])
           ->make(true);
    }

    public function newstudent(Request $request)
    {
        Applicant::where('id',$request->check)->update(['applicant_status'=>'7A']);
        $applicant = Applicant::where('id',$request->check)->first();
        Student::create([
            'students_name' => $applicant['applicant_name'],
            'students_ic' => $applicant['applicant_ic'],
            'students_email' => $applicant['applicant_email'],
            'students_phone' => $applicant['applicant_phone'],
            'students_gender' => $applicant['applicant_gender'],
            'students_marital' => $applicant['applicant_marital'],
            'students_nationality' => $applicant['applicant_nationality'],
            'students_race' => $applicant['applicant_race'],
            'students_religion' => $applicant['applicant_religion'],
            'students_dob' => $applicant['applicant_dob'],
            'students_programme' => $applicant['offered_programme'],
            'programme_status' => $applicant['applicant_status'],
            'students_major' => $applicant['offered_major'],
            'students_status' => $applicant['applicant_status'],
            'intake_id' => $applicant['intake_id'],
            'students_id' => $applicant['student_id'],
        ]);
        $password = Hash::make($applicant['applicant_ic']);
        User::create([
            'id' => $applicant['student_id'],
            'name' => $applicant['applicant_name'],
            'username' => $applicant['student_id'],
            'email' => $applicant['applicant_email'],
            'password' => $password,
        ]);
        DB::insert('INSERT INTO auth.model_has_roles(role_id,model_type,model_id) VALUES (?,?,?)',['5','App\User',$applicant['student_id']]);

        return redirect()->back()->with('message', 'Students have been added');
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

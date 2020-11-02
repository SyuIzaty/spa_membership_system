<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Applicant;
use App\Student;
use App\Intakes;
use App\User;
use App\Race;
use App\Religion;
use App\Gender;
use App\Marital;
use App\Country;
use App\ApplicantContact;
use App\StudentGuardian;
use App\ApplicantGuardian;
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
        $applicant = Applicant::where('intake_id',$intake['id'])->where('applicant_status','7A')->orWhere('applicant_status','5C')->get();

        return datatables()::of($applicant)
           ->addColumn('action', function ($applicant) {
               if($applicant['applicant_status'] == '5C'){
                    return '<a href="/physical-registration/'.$applicant->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>';
               }else{
                    return '<div class="badge border border-success text-success">Registered</div>';

               }
           })
           ->rawColumns(['action'])
           ->make(true);
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
        $applicant = Applicant::find($id);
        $country = Country::all();
        $marital = Marital::all();
        $religion = Religion::all();
        $race = Race::all();
        $gender = Gender::all();
        return view('physical-registration.edit', compact('applicant','gender','marital','race','religion','country'));
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
        Applicant::find($id)->update($request->all());
        ApplicantContact::where('applicant_id',$id)->update([
            'applicant_address_1' => $request->applicant_address_1,
            'applicant_address_2' => $request->applicant_address_2,
            'applicant_poscode' => $request->applicant_poscode,
            'applicant_city' => $request->applicant_city,
            'applicant_state' => $request->applicant_state,
            'applicant_country' => $request->applicant_country,
        ]);

        Student::create([
            'students_name' => $request->applicant_name,
            'students_ic' => $request->applicant_ic,
            'students_email' => $request->applicant_email,
            'students_phone' => $request->applicant_phone,
            'students_gender' => $request->applicant_gender,
            'students_marital' => $request->applicant_marital,
            'students_nationality' => $request->applicant_nationality,
            'students_race' => $request->applicant_race,
            'students_religion' => $request->applicant_religion,
            'students_dob' => $request->applicant_dob,
            'students_programme' => $request->offered_programme,
            'programme_status' => $request->applicant_status,
            'students_major' => $request->offered_major,
            'students_status' => $request->applicant_status,
            'intake_id' => $request->intake_id,
            'students_id' => $request->student_id,
        ]);

        $guardian = ApplicantGuardian::where('applicant_id',$id)->first();
        StudentGuardian::create([
            'id' => $request->student_id,
            'guardian_one_name' => $guardian->guardian_one_name,
            'guardian_one_relationship' => $guardian->guardian_one_relationship,
            'guardian_one_mobile' => $guardian->guardian_one_mobile,
            'guardian_one_address' => $guardian->guardian_one_address,
            'guardian_two_name' => $guardian->guardian_two_name,
            'guardian_two_relationship' => $guardian->guardian_two_relationship,
            'guardian_two_mobile' => $guardian->guardian_two_mobile,
            'guardian_two_address' => $guardian->guardian_two_address,
        ]);

        $password = Hash::make($request->applicant_ic);
        User::create([
            'id' => $request->student_id,
            'name' => $request->applicant_name,
            'username' => $request->student_id,
            'email' => $request->applicant_email,
            'password' => $password,
        ]);
        DB::insert('INSERT INTO auth.model_has_roles(role_id,model_type,model_id) VALUES (?,?,?)',['5','App\User',$request->student_id]);


        return redirect('physical-registration')->with('message', 'Student Registered');

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

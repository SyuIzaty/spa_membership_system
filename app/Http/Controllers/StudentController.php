<?php

namespace App\Http\Controllers;

use App\Student;
use App\Country;
use App\Religion;
use App\Marital;
use App\Gender;
use App\Race;
use App\State;
use App\StudentContact;
use App\StudentGuardian;
use App\StudentEmergency;
use App\CreditExemption;
use App\ProjectInfo;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentContactRequest;
use Datatables;
use Auth;
use Session;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$students = Student::take(10)->get();
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name')->take(10)->get();
        // dd($students);
        // return view('student.index');
    }

    public function indexFiltered($id)
    {
        if($id == 1)
            return view('student.index_nonnumericid');
        else if($id == 2)
            return view('student.index_nullname');
    }

    public function basic_info($id)
    {
        $student = Student::where('id', $id)->with(['studentContactInfo.country', 'studentGuardian', 'studentEmergency', 'race', 'gender', 'religion', 'programme'])->first();
        
        // dd($student);
        return view('student.biodata.basic_info', compact('student'));
    }

    public function addressContact_info($id)
    {
        $student = Student::where('id', $id)->with(['studentContactInfo.country', 'studentContactInfo.state'])->first();
        $country = Country::all();
        $state = State::all();

        return view('student.biodata.addressContact_info', compact('student', 'country', 'state'));
    }

    public function addressContact_edit($id)
    {
        $student = Student::where('id', $id)->with(['studentContactInfo.country', 'studentContactInfo.state'])->first();
        $country = Country::all();
        $state = State::all();

        return view('student.biodata.addressContact_edit', compact('student', 'country', 'state'));
    }

    public function updateStudent(StoreStudentContactRequest $request)
    {
        Student::where('id', $request->id)->update([
            'students_phone' => $request->students_phone,
            'students_email' => $request->students_email,
        ]);
        
        StudentContact::where('students_id', $request->id)->update([
            'students_address_1' => $request->students_address_1,
            'students_address_2' => $request->students_address_2,
            'students_poscode'   => $request->students_poscode,
            'students_city'      => $request->students_city,
            'students_country'   => $request->students_country, 
            'students_state'     => $request->students_state, 
        ]);

        Session::flash('message', 'Information updated successfully');
        return redirect('/student/biodata/addressContact_info/'. Auth::user()->id );
    }

    public function course_register()
    {
        return view('student.registration.course_register');
    }

    public function course_pdf()
    {
        return view('student.registration.courseSlip_pdf');
    }

    public function credit_exemption()
    {
        // $credit_exemp = CreditExemption::all();
        // return view('student.registration.credit_exemption', compact('credit_exemp'));
        return view('student.registration.credit_exemption');
    }

    // public function data_allCourse_exemp()
    // {
    //     $credit_exemp = CreditExemption::all();

    //     return datatables()::of($credit_exemp)

    //     ->make(true);
    // }

    public function project_info()
    {
        // $project = ProjectInfo::all();
        return view('student.registration.project_info');
    }

    // public function data_allProject()
    // {
    //     $project = ProjectInfo::all();

    //     return datatables()::of($project)

    //     ->make(true);
    // }

    public function course_performance()
    {
        return view('student.examination.course_performance');
    }

    // public function course_performance(Request $request)
    // {
    //     $year = $request->year; //db column name @
    //     $year = $date->format("Y");  @
    //     $year = date("Y", $date);

    //     // selection for request year
    //     if(isset($year) && !empty($year))
    //         $req_year = $year; // get from column year
    //     else
    //         $req_year = date('Y'); // get current year

    //     $find = MODEL::has('relationFunc')->where('year', $req_year)->get(); // relation dengan tbl findings - 'relationFunc' refer kepada model ?

    //     return view ('student.examination.course_performance', compact('find', 'req_year'));
    // }

    public function exam_details()
    {
        return view('student.examination.exam_details');
    }

    public function graduation_info()
    {
        return view('student.graduation.graduation_info');
    }

    public function stud_statement()
    {
        return view('student.financial.stud_statement');
    }

    public function activity_transcript()
    {
        return view('student.others.activity_trans');
    }

    public function residential_record()
    {
        return view('student.others.residential_rcrd');
    }

    public function residential_electric()
    {
        return view('student.others.resident_electric');
    }

    public function vehicle_record()
    {
        return view('student.others.vehicle_rcrd');
    }

    public function sw_download()
    {
        return view('student.services.sw_download');
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
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function data_allstudents()
    {
        // $students = Student::whereRaw("sm_student_id regexp '[^a-z0-9]'");
         $students = Student::select('*');
        // $students = Student::whereNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')");
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '\D')"); // returns records with non-numeric student_id
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');

       return datatables()::of($students)
        //    ->addColumn('group', function($student){
        //        return $student->group->name;
        //    })
           ->addColumn('action', function ($students) {
               return '<a href="/student/'.$students->SM_STUDENT_ID.'/edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
           })
           ->make(true);
    }

    public function data_studentWithNonNumericId()
    {
        // $students = Student::whereRaw("sm_student_id regexp '[^a-z0-9]'");
        // $students = Student::select('*');
        // $students = Student::whereNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')");
         $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '\D')"); // returns records with non-numeric student_id
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');

       return datatables()::of($students)
        //    ->addColumn('group', function($student){
        //        return $student->group->name;
        //    })
           ->addColumn('action', function ($students) {
               return '<a href="/student/'.$students->SM_STUDENT_ID.'/edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
           })
           ->make(true);
    }

    public function data_studentWithNullName()
    {
        // $students = Student::whereRaw("sm_student_id regexp '[^a-z0-9]'");
        // $students = Student::select('*');
        $students = Student::whereNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')");
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '\D')"); // returns records with non-numeric student_id
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');
        // $students = Student::whereRaw("REGEXP_LIKE(sm_student_id, '^[[:digit:]]+$')")->whereNotNull('sm_student_name');

       return datatables()::of($students)
        //    ->addColumn('group', function($student){
        //        return $student->group->name;
        //    })
           ->addColumn('action', function ($students) {
               return '<a href="/student/'.$students->SM_STUDENT_ID.'/edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
           })
           ->make(true);
    }
}
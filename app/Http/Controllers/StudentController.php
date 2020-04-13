<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Datatables;

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
        return view('student.index');
    }

    public function indexFiltered($id)
    {
        if($id == 1)
            return view('student.index_nonnumericid');
        else if($id == 2)
            return view('student.index_nullname');
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

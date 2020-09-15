<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $course = Course::all();
       return view('param.course.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data_allCourse()
    {
        $course = Course::all();

        return datatables()::of($course)
        ->addColumn('action', function ($course) {

            return '
            <a href="/param/course/' . $course->id . '/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
            <a href="/param/course/' . $course->id . '" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/param/course/' . $course->id . '"> <i class="fal fa-trash"></i> Delete</button>'
            ;
        })

        ->editColumn('created_at', function ($course) {

            return date(' Y-m-d ', strtotime($course->updated_at) );
        })

        ->make(true);
    }

    public function create()
    {
        return view('param.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Course::create($this->validateRequestStore());
        return redirect('param/course');
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'id'                => 'required|min:1|max:255|unique:courses,id',                       
            'course_code'       => 'required|min:1|max:255|unique:courses,course_code',  
            'course_name'       => 'required|min:1|max:255',    
            'credit_hours'      => 'required',
            'course_status'     => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $arr['course'] = $course;
        return view('param.course.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('param.course.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $course->update($this->validateRequestUpdate($course));
        return redirect('param/course');
    }

    public function validateRequestUpdate(Course $course)
    {
        return request()->validate([
            'id'                => 'required|min:1|max:255|unique:courses,id,'. $course->id,                       
            'course_code'       => 'required|min:1|max:255|unique:courses,course_code,'. $course->course_code,  
            'course_name'       => 'required|min:1|max:255',    
            'credit_hours'      => 'required',
            'course_status'     => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Course::find($id);
        $exist->delete();
        return response()->json(['success'=>'Major deleted successfully.']);
    }

    // public function data_allcourses()
    // {
    //      $students = Course::select('*');

    //    return datatables()::of($students)
    //        ->addColumn('action', function ($students) {
    //            return '<a href="/student/'.$students->SM_STUDENT_ID.'/edit" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
    //        })
    //        ->make(true);
    // }
}

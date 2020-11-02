<?php

namespace App\Http\Controllers;

use App\Course;
use App\PreRequisite;
use App\CoRequisite;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;

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

            return date(' Y-m-d | H:i A ', strtotime($course->updated_at) );
        })

        ->editColumn('course_status', function ($course) {

            return strtoupper($course->course_status ? 'Active' : 'Inactive');
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

    public function store(StoreCourseRequest $request)
    {
        Course::create([
            'id'                => $request->course_id,
            'course_code'       => $request->course_code,
            'course_name_bm'    => $request->course_name_bm,
            'course_name'       => $request->course_name,
            'credit_hours'      => $request->credit_hours, 
            'lecturer_hours'    => $request->lecturer_hours,
            'lab_hours'         => $request->lab_hours, 
            'tutorial_hours'    => $request->tutorial_hours, 
            'exam_duration'     => $request->exam_duration, 
            'final_exam'        => $request->final_exam, 
            'project_course'    => $request->project_course,
            'course_status'     => $request->course_status,
        ]);

        return redirect('param/course');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $pre = PreRequisite::where('courses_id', $course->id)->get();
        $co = CoRequisite::where('courses_id', $course->id)->get();

        return view('param.course.show', compact('course', 'pre', 'co'))->with('no', 1)->with('nos', 1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $pre = PreRequisite::where('courses_id', $course->id)->get();
        $co = CoRequisite::where('courses_id', $course->id)->get();

        $pcCourse = Course::all();

        return view('param.course.edit',compact('course', 'pre', 'co', 'pcCourse'))->with('no', 1)->with('nos', 1);
    }

    public function preInfo(Request $request)
    {
        $course = Course::where('id', $request->id)->first(); 

        PreRequisite::where('courses_id', $course->id)->delete();

        foreach($request->pre_requisite_course as $value){
            $fields = [
                'courses_id' => $course->id,
                'pre_requisite_course' => $value
            ];

            PreRequisite::create($fields);
            
        }

        return redirect('param/course/'.$course->id.'/edit');
    }

    public function coInfo(Request $request)
    {
        $course = Course::where('id', $request->id)->first(); 

        CoRequisite::where('courses_id', $course->id)->delete();

        foreach($request->co_requisite_course as $value){
            $fields = [
                'courses_id' => $course->id,
                'co_requisite_course' => $value
            ];
 
            CoRequisite::create($fields);
            
        }

        return redirect('param/course/'.$course->id.'/edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCourseRequest $request)
    {
        $course = Course::where('id', $request->id)->first();

        $course->update([
            'id'                => $request->course_id,
            'course_code'       => $request->course_code,
            'course_name_bm'    => $request->course_name_bm,
            'course_name'       => $request->course_name,
            'credit_hours'      => $request->credit_hours, 
            'lecturer_hours'    => $request->lecturer_hours,
            'lab_hours'         => $request->lab_hours, 
            'tutorial_hours'    => $request->tutorial_hours, 
            'exam_duration'     => $request->exam_duration, 
            'final_exam'        => $request->final_exam, 
            'project_course'    => $request->project_course,
            'course_status'     => $request->course_status,
        ]);

        return redirect('param/course/'.$course->id.'/edit');
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

}

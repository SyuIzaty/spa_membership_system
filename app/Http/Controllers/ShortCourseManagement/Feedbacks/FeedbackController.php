<?php

namespace App\Http\Controllers\ShortCourseManagement\Feedbacks;

use App\Models\ShortCourseManagement\Question;
use App\Models\ShortCourseManagement\Section;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function form()
    {
        //
        $sections = Section::all()->load(['questions']);
        // $index = 0;
        // foreach ($sections as $section) {
        //     $sections[$index]['questions'] = Question::where('section_id', $section->id)->first();
        //     $index++;
        // }
        return view('short-course-management.feedback.index', compact('sections'));
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

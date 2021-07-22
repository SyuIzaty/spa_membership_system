<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\ShortCourse;
use App\Models\ShortCourseManagement\ShortCourse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShortCourseController extends Controller
{
    public function index()
    {
        //
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

    public function searchById($id)
    {
        //
        $shortcourse=ShortCourse::where('id', $id)->first();
        return $shortcourse;
    }


}

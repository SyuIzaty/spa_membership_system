<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\ShortCourse;
use App\Models\ShortCourseManagement\ShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class ShortCourseController extends Controller
{
    public function index()
    {
        //
        return view('short-course-management.catalogues.course-catalogue.index');
    }

    public function dataShortCourses()
    {
        $shortcourses = ShortCourse::orderByDesc('id')->get()->load(['events_shortcourses', 'topics_shortcourses.topic']);
        $index=0;
        foreach($shortcourses as $shortcourse){

            if (isset($shortcourse->events_shortcourses)) {
                $totalEvents = $shortcourse->events_shortcourses->count();
                // dd($totalEvents);
            } else {
                $totalEvents = 0;
            }
            $shortcourses[$index]->totalEvents = $totalEvents;
            $shortcourses[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($shortcourses[$index]->created_at), 'g:ia \o\n l jS F Y');
            $shortcourses[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($shortcourses[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index+=1;
        }


        return datatables()::of($shortcourses)
            ->addColumn('dates', function ($shortcourses) {
                return 'Created At:<br>' . $shortcourses->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $shortcourses->updated_at_toDayDateTimeString;
            })
            ->addColumn('events', function ($shortcourses) {
                return 'Total Events: ' . $shortcourses->totalEvents ;
            })
            ->addColumn('management_details', function ($shortcourses) {
                return 'Created By: ' . $shortcourses->created_by . '<br> Created At: ' . $shortcourses->created_at;
            })
            ->addColumn('action', function ($shortcourses) {
                return '
                <a href="/shortcourses/' . $shortcourses->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->rawColumns(['action', 'management_details', 'events', 'dates'])
            ->make(true);

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

        $shortcourse = ShortCourse::find($id)->load([
            'topics_shortcourses.topic',
        ]);


        $topics=Topic::all();

        return view('short-course-management.catalogues.course-catalogue.show', compact('shortcourse','topics',));

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'objective' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'description.required' => 'Please insert short course description',
            'objective.required' => 'Please insert short course objective',
        ]);

        $update = ShortCourse::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'objective' => $request->objective,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('messageShortCourseBasicDetails', 'Basic Details Update Successfully');
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

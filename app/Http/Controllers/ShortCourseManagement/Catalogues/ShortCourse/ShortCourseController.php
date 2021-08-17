<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\ShortCourse;

use App\Models\ShortCourseManagement\ShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\Models\ShortCourseManagement\TopicShortCourse;
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
        $index = 0;
        foreach ($shortcourses as $shortcourse) {

            if (isset($shortcourse->events_shortcourses)) {
                $totalEvents = $shortcourse->events_shortcourses->count();
                // dd($totalEvents);
            } else {
                $totalEvents = 0;
            }
            $shortcourses[$index]->totalEvents = $totalEvents;
            $shortcourses[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($shortcourses[$index]->created_at), 'g:ia \o\n l jS F Y');
            $shortcourses[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($shortcourses[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index += 1;
        }


        return datatables()::of($shortcourses)
            ->addColumn('dates', function ($shortcourses) {
                return 'Created At:<br>' . $shortcourses->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $shortcourses->updated_at_toDayDateTimeString;
            })
            ->addColumn('events', function ($shortcourses) {
                return 'Total Events: ' . $shortcourses->totalEvents;
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
        $validated = $request->validate([
            'shortcourse_name' => 'required',
        ], [
            'shortcourse_name.required' => 'Please insert a name',
        ]);

        $create = ShortCourse::create([
            'name' => $request->shortcourse_name,
            'description' => "No Description",
            'objective' => "No Objective",
            'created_by' => Auth::user()->id,
        ]);

        $shortcourse = ShortCourse::find($create->id)->load([
            'topics_shortcourses.topic',
            'events_shortcourses'
        ]);


        if (isset($shortcourse->events_shortcourses)) {
            $totalEvents = $shortcourse->events_shortcourses->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $shortcourse->totalEvents = $totalEvents;


        $topics = Topic::all();

        // return view('short-course-management.catalogues.course-catalogue.show', compact('shortcourse','topics',));
        return redirect('/shortcourses/' . $shortcourse->id)->with(compact('shortcourse', 'topics'));
    }
    public function show($id)
    {

        $shortcourse = ShortCourse::find($id)->load([
            'topics_shortcourses.topic',
            'events_shortcourses'
        ]);


        if (isset($shortcourse->events_shortcourses)) {
            $totalEvents = $shortcourse->events_shortcourses->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $shortcourse->totalEvents = $totalEvents;


        $topics = Topic::all();

        return view('short-course-management.catalogues.course-catalogue.show', compact('shortcourse', 'topics',));
    }

    public function delete(Request $request, $id)
    {

        $exist = ShortCourse::find($id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();
        return $exist;
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
        $shortcourse = ShortCourse::where('id', $id)->first();
        return $shortcourse;
    }

    public function storeTopicShortCourse(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'shortcourse_topic' => 'required',
        ], [
            'shortcourse_topic.required' => 'Please insert atleast a topic',
        ]);

        $create = TopicShortCourse::create([
            'topic_id' => $request->shortcourse_topic,
            'shortcourse_id' => $id,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);

        return $create;
    }

    public function removeTopicShortCourse(Request $request, $id)
    {

        $exist = TopicShortCourse::find($id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageShortCourseBasicDetails', 'Remove a topic Successfully');
    }
}

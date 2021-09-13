<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\ShortCourse;

use App\Models\ShortCourseManagement\ShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\Models\ShortCourseManagement\TopicShortCourse;
use App\Models\ShortCourseManagement\ShortCourseICDLModule;
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
            'shortcourse_type' => 'required',
            'description' => 'required',
            'objective' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'shortcourse_type' => 'Please choose shortcourse type',
            'description.required' => 'Please insert short course description',
            'objective.required' => 'Please insert short course objective',
        ]);

        $update = ShortCourse::find($id)->update([
            'name' => $request->name,
            'is_icdl' => $request->shortcourse_type,
            'description' => $request->description,
            'objective' => $request->objective,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('successUpdate', 'Short Course Information Updated Successfully');
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
        // $_SESSION['successUpdate'] = $_POST['New Topic Attached to the Short Course Successfully'];
        return $create;
        // return Redirect()->back()->with('successUpdate', 'New Topic Attached to the Short Course Successfully');
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

        return Redirect()->back()->with('successUpdate', 'A Topic Detached from the Short Course Successfully');
    }

    public function storeModule(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'shortcourse_module' => 'required',
        ], [
            'shortcourse_module.required' => 'Please insert module name',
        ]);

        $create = ShortCourseICDLModule::create([
            'name' => $request->shortcourse_module,
            'shortcourse_id' => $id,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);
        // $_SESSION['successUpdate'] = $_POST['New Topic Attached to the Short Course Successfully'];
        return $create;
        // return Redirect()->back()->with('successUpdate', 'New Topic Attached to the Short Course Successfully');
    }

    public function removeModule(Request $request, $id)
    {

        $exist = ShortCourseICDLModule::find($id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('successUpdate', 'A Module has been deleted from the Short Course Successfully');
    }

    public function storeShortCourseEvent(Request $request){
        //
        // dd($request);
        $validated = $request->validate([
            'shortcourse_name_new' => 'required',
            'shortcourse_type' => 'required',
            'objective' => 'required',
            'description' => 'required',
        ], [
            'shortcourse_name_new.required' => 'Please insert the new short course name',
            'shortcourse_type.required' => 'Please choose a short course type',
            'objective.required' => 'Please insert the new short course objective',
            'description.required' => 'Please insert the new short course description',
        ]);

        $createShortCourse = ShortCourse::create([
            'name' => $request->shortcourse_name_new,
            'description' => $request->description,
            'objective' => $request->objective,
            'created_by' => Auth::user()->id,
        ]);

        foreach ($request->shortcourse_modules as $shortcourse_module){
            $createModule = ShortCourseICDLModule::create([
                'name' => $shortcourse_module,
                'shortcourse_id' => $createShortCourse->id,
                'created_by' => Auth::user()->id,
            ]);
        }

        $shortcourse = ShortCourse::find($createShortCourse->id)->load([
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

        // return redirect()->back()->with('message', 'Bahan/Alat Ganti Berjaya Dipadam');
        return redirect()->back();

    }
}

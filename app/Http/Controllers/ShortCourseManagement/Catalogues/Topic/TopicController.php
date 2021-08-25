<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\Topic;

use App\Models\ShortCourseManagement\Topic;
use App\Models\ShortCourseManagement\TopicType;
use App\Models\ShortCourseManagement\SubCategory;
use App\Models\ShortCourseManagement\Category;
// use App\Models\ShortCourseManagement\TopicTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class TopicController extends Controller
{
    public function index()
    {
        //
        $subcategories = SubCategory::all();

        $categories = Category::all();
        return view('short-course-management.catalogues.topic-catalogue.index')->with(compact('subcategories', 'categories'));
    }

    public function dataTopics()
    {
        $topics = Topic::orderByDesc('id')->get()->load(['topics_shortcourses','subcategory']);
        $index = 0;
        foreach ($topics as $topic) {

            if (isset($topic->topics_shortcourses)) {
                $totalShortCourses = $topic->topics_shortcourses->count();
                // dd($totalShortCourses);
            } else {
                $totalShortCourses = 0;
            }
            $topics[$index]->totalShortCourses = $totalShortCourses;
            $topics[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($topics[$index]->created_at), 'g:ia \o\n l jS F Y');
            $topics[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($topics[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index += 1;
        }


        return datatables()::of($topics)
            ->addColumn('dates', function ($topics) {
                return 'Created At:<br>' . $topics->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $topics->updated_at_toDayDateTimeString;
            })
            ->addColumn('total_shortcourses', function ($topics) {
                return 'Total Short Courses: ' . $topics->totalShortCourses;
            })
            ->addColumn('management_details', function ($topics) {
                return 'Created By: ' . $topics->created_by . '<br> Created At: ' . $topics->created_at;
            })
            ->addColumn('action', function ($topics) {
                if ($topics->totalShortCourses != 0) {
                    return '
                    <a href="#" id="editTopic" data-target="#crud-modal-topic-edit" data-toggle="modal" data-id="' . $topics->id . '" data-name="' . $topics->name . '" data-subcategory_id="' . $topics->subcategory_id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/topic/delete/' . $topics->id . '" disabled><i class="fal fa-trash"></i>  Delete</button>
                    ';
                } else {
                    return '
                    <a href="#" id="editTopic" data-target="#crud-modal-topic-edit" data-toggle="modal" data-id="' . $topics->id . '" data-name="' . $topics->name . '" data-subcategory_id="' . $topics->subcategory_id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/topic/delete/' . $topics->id . '"><i class="fal fa-trash"></i>  Delete</button>
                ';
                }
            })
            ->rawColumns(['action', 'management_details', 'total_shortcourses', 'dates'])
            ->make(true);
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        // dd($request);
        //
        $validated = $request->validate([
            'topic_name' => 'required',
            'subcategory_id' => 'required',
        ], [
            'topic_name.required' => 'Please insert a name',
            'subcategory_id.required' => 'Please choose a subcategory',
        ]);

        $create = Topic::create([
            'name' => $request->topic_name,
            'subcategory_id' => $request->subcategory_id,
            'created_by' => Auth::user()->id,
        ]);
        return redirect('/topics');
    }
    public function show($id)
    {

        $topic = Topic::find($id)->load([
            'events',
        ]);
        $topic_types = TopicType::all();


        if (isset($topic->events)) {
            $totalEvents = $topic->events->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $topic->totalEvents = $totalEvents;

        return view('short-course-management.catalogues.topic-catalogue.show', compact('topic', 'topic_types'));
    }

    public function delete($id)
    {

        $exist = Topic::find($id);
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

    public function update(Request $request)
    {
        //
        // dd($request);

        $validated = $request->validate([
            'topic_name_edit' => 'required',
            'subcategory_id_edit' => 'required',
        ], [
            'topic_name_edit.required' => 'Please insert a name',
            'subcategory_id_edit.required' => 'Please choose a subcategory',
        ]);

        $update = Topic::find($request->topic_id_edit)->update([
            'name' => $request->topic_name_edit,
            'subcategory_id' => $request->subcategory_id_edit,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect('/topics');
    }

    public function destroy($id)
    {
        //
    }

    public function searchById($id)
    {
        //
        $topic = Topic::where('id', $id)->first();
        return $topic;
    }

    // public function storeTopicTopic(Request $request, $id)
    // {
    //     // dd($request);
    //     // //
    //     $validated = $request->validate([
    //         'topic_topic' => 'required',
    //     ], [
    //         'topic_topic.required' => 'Please insert atleast a topic',
    //     ]);

    //     $create = TopicTopic::create([
    //         'topic_id' => $request->topic_topic,
    //         'topic_id' => $id,
    //         'created_by' => Auth::user()->id,
    //         'is_active' => 1,
    //     ]);

    //     return $create;
    // }

    // public function removeTopicTopic(Request $request, $id)
    // {

    //     $exist = TopicTopic::find($id);
    //     if (Auth::user()->id) {
    //         $exist->updated_by = Auth::user()->id;
    //         $exist->deleted_by = Auth::user()->id;
    //     } else {
    //         $exist->updated_by = "public_user";
    //         $exist->deleted_by = "public_user";
    //     }
    //     $exist->save();
    //     $exist->delete();

    //     return Redirect()->back()->with('messageTopicBasicDetails', 'Remove a topic Successfully');
    // }


}

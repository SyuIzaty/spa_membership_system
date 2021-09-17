<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\TopicSubCategoryCategory;

use App\Models\ShortCourseManagement\SubCategory;
use App\Models\ShortCourseManagement\Category;
use App\Models\ShortCourseManagement\Topic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class SubCategoryController extends Controller
{
    public function index()
    {
    }

    public function dataSubCategories()
    {
        $subcategories = SubCategory::orderByDesc('id')->get()->load(['topics','category']);
        $index = 0;
        foreach ($subcategories as $subcategory) {

            if (isset($subcategory->topics)) {
                $totalTopics = $subcategory->topics->count();
            } else {
                $totalTopics = 0;
            }
            $subcategories[$index]->totalTopics = $totalTopics;
            $subcategories[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($subcategories[$index]->created_at), 'g:ia \o\n l jS F Y');
            $subcategories[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($subcategories[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index += 1;
        }


        return datatables()::of($subcategories)
            ->addColumn('dates', function ($subcategories) {
                return 'Created At:<br>' . $subcategories->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $subcategories->updated_at_toDayDateTimeString;
            })
            ->addColumn('total_topics', function ($subcategories) {
                return 'Total Topics: ' . $subcategories->totalTopics;
            })
            ->addColumn('management_details', function ($subcategories) {
                return 'Created By: ' . $subcategories->created_by . '<br> Created At: ' . $subcategories->created_at;
            })
            ->addColumn('action', function ($subcategories) {
                if ($subcategories->totalTopics != 0) {
                    return '
                    <a href="#" id="editSubCategory" data-target="#crud-modal-subcategory-edit" data-toggle="modal" data-id="' . $subcategories->id . '" data-name="' . $subcategories->name . '" data-category_id="' . $subcategories->category_id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/subcategory/delete/' . $subcategories->id . '" disabled><i class="fal fa-trash"></i>  Delete</button>
                    ';
                } else {
                    return '
                    <a href="#" id="editSubCategory" data-target="#crud-modal-subcategory-edit" data-toggle="modal" data-id="' . $subcategories->id . '" data-name="' . $subcategories->name . '" data-category_id="' . $subcategories->category_id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/subcategory/delete/' . $subcategories->id . '"><i class="fal fa-trash"></i>  Delete</button>
                ';
                }
            })
            ->rawColumns(['action', 'management_details', 'total_topics', 'dates'])
            ->make(true);
    }

    public function create()
    {
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcategory_name_2' => 'required',
            'category_id_2' => 'required',
        ], [
            'subcategory_name_2.required' => 'Please insert a sub-category name',
            'category_id_2.required' => 'Please choose a category',
        ]);

        $create = SubCategory::create([
            'name' => $request->subcategory_name_2,
            'category_id' => $request->category_id_2,
            'created_by' => Auth::user()->id,
        ]);
        return redirect('/topics');
    }
    public function show($id)
    {

        $subcategory = SubCategory::find($id)->load([
            'events',
        ]);
        $subcategory_types = SubCategoryType::all();


        if (isset($subcategory->events)) {
            $totalEvents = $subcategory->events->count();
        } else {
            $totalEvents = 0;
        }
        $subcategory->totalEvents = $totalEvents;

        return view('short-course-management.catalogues.subcategory-catalogue.show', compact('subcategory', 'subcategory_types'));
    }

    public function delete($id)
    {

        $exist = SubCategory::find($id);
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
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'subcategory_name_edit_2' => 'required',
            'category_id_edit_2' => 'required',
        ], [
            'subcategory_name_edit_2.required' => 'Please insert a name',
            'category_id_edit_2.required' => 'Please choose a subcategory',
        ]);

        $update = SubCategory::find($request->subcategory_id_edit_2)->update([
            'name' => $request->subcategory_name_edit_2,
            'category_id' => $request->category_id_edit_2,
            'updated_by' => Auth::user()->id,
        ]);

        return redirect('/topics');
    }

    public function destroy($id)
    {
    }

    public function searchById($id)
    {
        $subcategory = SubCategory::where('id', $id)->first();
        return $subcategory;
    }

    public function getTopics($subcategory_id){
        $topics = Topic::where('subcategory_id', $subcategory_id)->get();
        return $topics;
    }
}

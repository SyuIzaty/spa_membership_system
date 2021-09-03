<?php

namespace App\Http\Controllers\ShortCourseManagement\Catalogues\TopicSubCategoryCategory;

// use App\Models\ShortCourseManagement\Category;
use App\Models\ShortCourseManagement\Category;
use App\Models\ShortCourseManagement\SubCategory;
// use App\Models\ShortCourseManagement\CategoryCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
    }

    public function dataCategories()
    {
        $categories = Category::orderByDesc('id')->get()->load(['subcategories']);
        $index = 0;
        foreach ($categories as $category) {

            if (isset($category->subcategories)) {
                $totalSubcategories = $category->subcategories->count();
                // dd($totalSubcategories);
            } else {
                $totalSubcategories = 0;
            }
            $categories[$index]->totalSubcategories = $totalSubcategories;
            $categories[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($categories[$index]->created_at), 'g:ia \o\n l jS F Y');
            $categories[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($categories[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index += 1;
        }


        return datatables()::of($categories)
            ->addColumn('dates', function ($categories) {
                return 'Created At:<br>' . $categories->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $categories->updated_at_toDayDateTimeString;
            })
            ->addColumn('total_subcategories', function ($categories) {
                return 'Total Subcategories: ' . $categories->totalSubcategories;
            })
            ->addColumn('management_details', function ($categories) {
                return 'Created By: ' . $categories->created_by . '<br> Created At: ' . $categories->created_at;
            })
            ->addColumn('action', function ($categories) {
                if ($categories->totalSubcategories != 0) {
                    return '
                    <a href="#" id="editCategory" data-target="#crud-modal-category-edit" data-toggle="modal" data-id="' . $categories->id . '" data-name="' . $categories->name . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/category/delete/' . $categories->id . '" disabled><i class="fal fa-trash"></i>  Delete</button>
                    ';
                } else {
                    return '
                    <a href="#" id="editCategory" data-target="#crud-modal-category-edit" data-toggle="modal" data-id="' . $categories->id . '" data-name="' . $categories->name . '" data-category_id="' . $categories->category_id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/category/delete/' . $categories->id . '"><i class="fal fa-trash"></i>  Delete</button>
                ';
                }
            })
            ->rawColumns(['action', 'management_details', 'total_subcategories', 'dates'])
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
            'category_name_3' => 'required',
        ], [
            'category_name_3.required' => 'Please insert a category name',
        ]);

        $create = Category::create([
            'name' => $request->category_name_3,
            'created_by' => Auth::user()->id,
        ]);
        return redirect('/topics');
    }
    public function show($id)
    {

        $subcategory = Category::find($id)->load([
            'events',
        ]);
        $subcategory_types = CategoryType::all();


        if (isset($subcategory->events)) {
            $totalEvents = $subcategory->events->count();
            // dd($totalEvents);
        } else {
            $totalEvents = 0;
        }
        $subcategory->totalEvents = $totalEvents;

        return view('short-course-management.catalogues.subcategory-catalogue.show', compact('subcategory', 'subcategory_types'));
    }

    public function delete($id)
    {

        $exist = Category::find($id);
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

        $validated = $request->validate([
            'category_name_edit_3' => 'required',
        ], [
            'category_name_edit_3.required' => 'Please insert a name',
        ]);

        $update = Category::find($request->category_id_edit_3)->update([
            'name' => $request->category_name_edit_3,
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
        $subcategory = Category::where('id', $id)->first();
        return $subcategory;
    }

    public function getSubCategories($category_id){
        $subcategories = SubCategory::where('category_id', $category_id)->get();
        return $subcategories;
    }

    // public function storeCategoryCategory(Request $request, $id)
    // {
    //     // dd($request);
    //     // //
    //     $validated = $request->validate([
    //         'subcategory_subcategory' => 'required',
    //     ], [
    //         'subcategory_subcategory.required' => 'Please insert atleast a subcategory',
    //     ]);

    //     $create = CategoryCategory::create([
    //         'subcategory_id' => $request->subcategory_subcategory,
    //         'subcategory_id' => $id,
    //         'created_by' => Auth::user()->id,
    //         'is_active' => 1,
    //     ]);

    //     return $create;
    // }

    // public function removeCategoryCategory(Request $request, $id)
    // {

    //     $exist = CategoryCategory::find($id);
    //     if (Auth::user()->id) {
    //         $exist->updated_by = Auth::user()->id;
    //         $exist->deleted_by = Auth::user()->id;
    //     } else {
    //         $exist->updated_by = "public_user";
    //         $exist->deleted_by = "public_user";
    //     }
    //     $exist->save();
    //     $exist->delete();

    //     return Redirect()->back()->with('messageCategoryBasicDetails', 'Remove a subcategory Successfully');
    // }


}

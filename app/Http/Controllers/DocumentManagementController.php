<?php

namespace App\Http\Controllers;

use DB;
use File;
use App\User;
use Response;
use App\Staff;
use App\DocumentAdmin;
use App\DocumentStaff;
use App\DepartmentList;
use App\DocumentFolder;
use App\DocumentCategory;
use App\DocumentManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $department = DepartmentList::all();
        $list = DocumentManagement::whereNull('folder_id')->orderBy('category', 'ASC')->get(); //then orderby doc name

        $count = DepartmentList::select('id', 'name')->withCount('document')->orderByDesc('document_count')->get();

        $category = DocumentCategory::all();

        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('id', 'DMS001');
        })->get();

        $privateFolder = DocumentFolder::where('category', 'p')->wherehas('staffDept', function ($query) {
            $query->where('staff_id', Auth::user()->id);
        })->get();

        $publicFolder =  DocumentFolder::get();

        return view('eDocument.index', compact('list', 'department', 'count', 'category', 'admins', 'superAdmin', 'privateFolder', 'publicFolder'));
    }

    public function upload()
    {
        $id = '';
        $category = DocumentCategory::all();
        $department = DepartmentList::all();
        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $admin = DocumentAdmin::where('admin_id', Auth::user()->id)->first();

        $file = DocumentManagement::whereNull('folder_id')->wherehas('admin.department', function ($query) use ($admin) {
            $query->where('id', $admin->department_id);
        })->get();

        $folder = DocumentFolder::wherehas('admin.department', function ($query) use ($admin) {
            $query->where('id', $admin->department_id);
        })->get();


        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('id', 'DMS001');
        })->get();

        $department_id = $admin->department_id;

        return view('eDocument.upload', compact('id', 'department', 'category', 'admins', 'file', 'admin', 'superAdmin', 'department_id', 'folder'));
    }

    public function getUpload($id)
    {
        $category = DocumentCategory::all();
        $file = DocumentManagement::where('department_id', $id)->get();
        $folder = DocumentFolder::where('department_id', $id)->get();

        $getDepartment = DepartmentList::where('id', $id)->first();
        $department = DepartmentList::all();

        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function ($query) {
            $query->where('id', 'DMS001');
        })->get();

        $department_id = $id;
        return view('eDocument.upload', compact('id', 'file', 'getDepartment', 'department', 'category', 'admins', 'superAdmin', 'department_id', 'folder'));
    }

    public function storeDoc(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $originalName = $file->getClientOriginalName();
            $fileName = date('dmY_Hi')."_".$originalName;
            $title = current(explode(".", $originalName));
            $ext = substr($originalName, strpos($originalName, ".") + 1);
            $file_ext = str_pad(".", STR_PAD_LEFT) . $ext;
            // $request->file('file')->storeAs('/eDocument', $fileName);
            // $file->move(('/eDocument'), $fileName);
            // DocumentManagement::create([
            //     'department_id' => $request->id,
            //     'upload'        => $fileName,
            //     'title'         => $title,
            //     'file_ext'      => $file_ext,
            //     'original_name' => $originalName,
            //     'web_path'      => "eDocument/".$fileName,
            //     'created_by'    => Auth::user()->id
            // ]);

            Storage::put("/eDocument/".$fileName, file_get_contents($file));
            // $file->storeAs('/eDocument', date('dmyhi').' - '.$fileName);

            DocumentManagement::create([
                'department_id' => $request->id,
                'upload'        => $fileName,
                'title'         => $title,
                'file_ext'      => $file_ext,
                'original_name' => $originalName,
                'web_path'      => "eDocument/".$fileName,
                'created_by'    => Auth::user()->id
        ]);
        }

        return response()->json(['success'=>$originalName]);
    }

    public function getDoc($id)
    {
        // $file = DocumentManagement::where('id', $id)->first();
        // $path = storage_path().'/eDocument/'.$file->upload;

        // $doc = File::get($path);
        // $filetype = File::mimeType($path);

        // $response = Response::make($doc, 200);
        // $response->header("Content-Type", $filetype);

        // return $response;


        $file = DocumentManagement::where('id', $id)->first();
        // dd($file);
        return Storage::response($file->web_path);
    }

    public function deleteDoc($id)
    {
        $exist = DocumentManagement::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return response() ->json(['success' => 'Deleted!']);
    }

    public function updateTitle(Request $request)
    {
        if ($request->ajax()) {
            if ($request->action == 'edit') {
                $update = DocumentManagement::where('id', $request->id)->first();
                $update->update([
                    'title' => $request->title,
                    'category' => $request->category,
                    'updated_by'  => Auth::user()->id
                ]);
            }

            if ($request->action == 'delete') {
                DocumentManagement::find($request->id)->delete();
            }

            return response()->json($request);
        }
    }

    public function edit(Request $request)
    {
        $update = DocumentManagement::where('id', $request->id)->first();
        $update->update([
            'title' => $request->title,
            'category' => $request->category,
            'updated_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function departmentList()
    {
        return view('eDocument.department-list');
    }

    public function getDepartment()
    {
        $department = DepartmentList::all();

        return datatables()::of($department)

            ->editColumn('department', function ($department) {
                return $department->name;
            })

            ->editColumn('total', function ($department) {
                return DocumentAdmin::where('department_id', $department->id)->count();
            })

            ->addColumn('update', function ($department) {
                return '<a href="/update-admin/'.$department->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['update'])
            ->make(true);
    }

    public function adminList($id)
    {
        $department = DepartmentList::where('id', $id)->first();
        // $mainAdmin =  User::whereHas('roles', function ($query) {
        //     $query->where('id', 'DMS002');
        // })->get();

        $staff = Staff::get();
        $admin = DocumentAdmin::where('department_id', $id)->get();
        $staffs = DocumentStaff::where('department_id', $id)->get();

        return view('eDocument.admin-list', compact('id', 'department', 'staff', 'admin', 'staffs'));
    }

    public function store(Request $request)
    {
        $error = [];
        $message = '';

        foreach ($request->admin as $key => $value) {
            if (DocumentAdmin::where('department_id', $request->id)->where('admin_id', $value)->count() > 0) {
                $staff = User::where('id', $value)->first();
                $error[] = $staff->name;
            } else {
                DocumentAdmin::create([
                    'admin_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);

                $user = User::find($value);

                if (!$user->hasRole('eDocument (Admin)')) {
                    $user->assignRole('eDocument (Admin)');
                }
            }
        }

        if ($error) {
            $message = "[".implode(',', $error)."] already inserted";
        }

        if ($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Admin Added!');
        }
    }

    public function destroy($id)
    {
        $admin = DocumentAdmin::where('id', $id)->first();

        $user = User::find($admin->admin_id);

        $user->removeRole('eDocument (Admin)');

        $exist = DocumentAdmin::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return redirect('update-admin/'.$admin->department_id);
    }

    public function createFolder(Request $request)
    {
        DocumentFolder::create([
            'department_id' => $request->id,
            'title'         => $request->folderTitle,
            'created_by'    => Auth::user()->id,
            'updated_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Folder Created!');
    }

    public function folder($id)
    {
        $category = DocumentCategory::all();
        $file = DocumentManagement::where('folder_id', $id)->orderBy('category', 'ASC')->get();
        $folder = DocumentFolder::where('id', $id)->first();

        return view('eDocument.folder_upload', compact('category', 'file', 'folder'));
    }

    public function storeFileFolder(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $originalName = $file->getClientOriginalName();
            $fileName = date('dmY_Hi')."_".$originalName;
            $title = current(explode(".", $originalName));
            $ext = substr($originalName, strpos($originalName, ".") + 1);
            $file_ext = str_pad(".", STR_PAD_LEFT) . $ext;

            Storage::put("/eDocument/".$fileName, file_get_contents($file));

            DocumentManagement::create([
                'department_id' => $request->dept_id,
                'folder_id'    => $request->fol_id,
                'upload'        => $fileName,
                'title'         => $title,
                'file_ext'      => $file_ext,
                'original_name' => $originalName,
                'web_path'      => "eDocument/".$fileName,
                'created_by'    => Auth::user()->id
        ]);
        }

        return response()->json(['success'=>$originalName]);
    }

    public function deleteFolder(Request $request)
    {
        $folder = DocumentFolder::find($request->id);
        $folder->update(['deleted_by' => Auth::user()->id]);
        $folder->delete();

        $file = DocumentManagement::where('folder_id', $request->id)->get();

        if (isset($file)) {
            foreach ($file as $f) {
                $f->update(['deleted_by' => Auth::user()->id]);
                $f->delete();
            }
        }

        return response()->json(['success' => 'Deleted!']);
    }

    public function storeStaff(Request $request)
    {
        $error = [];
        $message = '';

        foreach ($request->staff as $key => $value) {
            if (DocumentStaff::where('department_id', $request->id)->where('staff_id', $value)->count() > 0) {
                $staff = User::where('id', $value)->first();
                $error[] = $staff->name;
            } else {
                DocumentStaff::create([
                    'staff_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);
            }
        }

        if ($error) {
            $message = "[".implode(',', $error)."] already inserted";
        }

        if ($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Staff Added!');
        }
    }

    public function deleteStaff($id)
    {
        $exist = DocumentStaff::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return redirect()->back();
    }
}

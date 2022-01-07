<?php

namespace App\Http\Controllers;

use App\DocumentManagement;
use App\DocumentCategory;
use App\DepartmentList;
use App\DocumentAdmin;
use App\User;
use File;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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
        $list = DocumentManagement::orderBy('category', 'ASC')->get();

        $count = DepartmentList::select('id', 'name')->withCount('document')->orderByDesc('document_count')->get();

        $category = DocumentCategory::all();
        
        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function($query){
            $query->where('id', 'DMS001');
        })->get();

        return view('eDocument.index', compact('list','department','count','category','admins','superAdmin'));
    }

    public function upload()
    {
        $id = '';
        $category = DocumentCategory::all();
        $department = DepartmentList::all();
        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $admin = DocumentAdmin::where('admin_id', Auth::user()->id)->first();

        $file = DocumentManagement::wherehas('admin.department', function($query) use ($admin){
            $query->where('id',$admin->department_id);})->get();

        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function($query){
            $query->where('id', 'DMS001');
        })->get();
    

        return view('eDocument.upload', compact('id','department','category','admins','file','admin','superAdmin'));
    }

    public function getUpload($id)
    {
        $category = DocumentCategory::all();
        $file = DocumentManagement::where('department_id', $id)->orderBy('category', 'ASC')->get();
        $getDepartment = DepartmentList::where('id',$id)->first();
        $department = DepartmentList::all();

        $admins = DocumentAdmin::where('admin_id', Auth::user()->id)->get();

        $superAdmin = User::where('id', Auth::user()->id)->whereHas('roles', function($query){
            $query->where('id', 'DMS001');
        })->get();

        return view('eDocument.upload', compact('id','file','getDepartment','department','category','admins','superAdmin'));
    }
    
    public function storeDoc(Request $request)
    {
        $file = $request->file('file');
       
        $path = storage_path()."/eDocument/";

        if (isset($file)) { 
            $originalName = $file->getClientOriginalName();
            $fileName = date('dmY_Hi')."_".$originalName;
            $title = current(explode(".", $originalName));
            $file->storeAs('/eDocument', $fileName);
            DocumentManagement::create([
                'department_id' => $request->id,
                'upload'        => $fileName,
                'title'         => $title,
                'original_name' => $originalName,
                'web_path'      => "app/eDocument/".$fileName,
                'created_by'    => Auth::user()->id
            ]);
        }

        return response()->json(['success'=>$originalName]);
    }

    public function getDoc($id)
    {
        $file = DocumentManagement::where('id', $id)->first();
        $path = storage_path().'/'.'app'.'/eDocument/'.$file->upload;

        $doc = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($doc, 200);
        $response->header("Content-Type", $filetype);
        
        return $response;
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
        
        if($request->ajax()){
            if($request->action == 'edit'){
                $update = DocumentManagement::where('id', $request->id)->first();
                $update->update([
                    'title' => $request->title,
                    'category' => $request->category,
                    'updated_by'  => Auth::user()->id
                ]);
            }

            if($request->action == 'delete'){
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

        return redirect()->back()->with('message','Update Successfully');
    }

    public function departmentList()
    {
        return view('eDocument.department-list');
    }

    public function getDepartment()
    {
        $department = DepartmentList::all();

        return datatables()::of($department)

            ->editColumn('department',function($department)
            {
                return $department->name;
            })

            ->editColumn('total',function($department)
            {
                return DocumentAdmin::where('department_id',$department->id)->count();
            })

            ->addColumn('update', function ($department) {

                return '<a href="/update-admin/'.$department->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['update'])
            ->make(true);
    }

    public function adminList($id)
    {
        $department = DepartmentList::where('id',$id)->first();
        $mainAdmin =  User::whereHas('roles', function($query){
            $query->where('id', 'DMS002');
        })->get(); 

        $admin = DocumentAdmin::where('department_id',$id)->get();

        return view('eDocument.admin-list', compact('id','department','mainAdmin','admin'));
    }

    public function store(Request $request)
    {
        $error = [];
        $message = '';

        foreach($request->admin as $key => $value)
        {
            if (DocumentAdmin::where('department_id',$request->id)->where('admin_id', $value)->count() > 0)
            {
                $staff = User::where('id',$value)->first();
                $error[] = $staff->name;
            }
            
            else
            {
                DocumentAdmin::create([
                    'admin_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);
            }
        }

        if($error)
        {
            $message = "[".implode(',',$error)."] already inserted";
        }

        if($message)
        {
            return redirect()->back()->withErrors([$message]);
        }

        else
        {
            return redirect()->back()->with('message','Admin Added!');
        }
    }

    public function destroy($id)
    {
        $admin = DocumentAdmin::where('id', $id)->first();

        $exist = DocumentAdmin::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        return redirect('update-admin/'.$admin->department_id);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DocumentManagementSystem  $documentManagementSystem
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentManagementSystem $documentManagementSystem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentManagementSystem  $documentManagementSystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentManagementSystem $documentManagementSystem)
    {
        //
    }
}

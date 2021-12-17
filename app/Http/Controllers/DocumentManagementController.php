<?php

namespace App\Http\Controllers;

use App\DocumentManagement;
use App\DocumentCategory;
use App\DepartmentList;
use File;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('eDocument.index', compact('list','department','count'));
    }

    public function upload()
    {
        $id = '';
        $category = DocumentCategory::all();
        $department = DepartmentList::all();
        return view('eDocument.upload', compact('id','department','category'));
    }

    public function getUpload($id)
    {
        $category = DocumentCategory::all();
        $file = DocumentManagement::where('department_id', $id)->orderBy('category', 'ASC')->get();
        $getDepartment = DepartmentList::where('id',$id)->first();
        $department = DepartmentList::all();

        return view('eDocument.upload', compact('id','file','getDepartment','department','category'));
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
                'title'        => $title,
                'original_name' => $originalName,
                'web_path'      => "app/eDocument/".$fileName,
                'created_by' => Auth::user()->id
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentManagementSystem  $documentManagementSystem
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentManagementSystem $documentManagementSystem)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentManagementSystem  $documentManagementSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentManagementSystem $documentManagementSystem)
    {
        //
    }
}

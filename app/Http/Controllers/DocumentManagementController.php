<?php

namespace App\Http\Controllers;

use App\DocumentManagement;
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
        $id = '';
        $getDepartment = '';
        $department = DepartmentList::all();
        return view('eDocument.index', compact('department','id','getDepartment'));
    }

    public function getList($id)
    {
        $department = DepartmentList::all();
        $getDepartment = DepartmentList::where('id',$id)->first();
        
        return view('eDocument.index', compact('department','id','getDepartment'));
    }


    public function viewList($id)
    {            
        $list = DocumentManagement::where('department_id',$id)->get();
      
        return datatables()::of($list)

        ->editColumn('document', function ($list) {
            return '<a download="'.$list->original_name.'" href="/get-doc/'.$list->id.'">'.$list->original_name.'</a><br>';        
        })

        ->addIndexColumn()

        ->rawColumns(['document'])
        ->make(true);
    }


    public function upload($id)
    {
        $file = DocumentManagement::where('department_id', $id)->get();
        return view('eDocument.upload', compact('id','file'));
    }
    

    public function storeDoc(Request $request)
    {
        $file = $request->file('file');
       
        $path = storage_path()."/eDocument/";

        if (isset($file)) { 
            $originalName = $file->getClientOriginalName();
            $fileName = $originalName."_".date('d-m-Y_hia');
            $file->storeAs('/eDocument', $fileName);
            DocumentManagement::create([
                'department_id' => $request->id,
                'upload'        => $fileName,
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

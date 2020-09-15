<?php

namespace App\Http\Controllers;

use App\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $major = Major::all();
        return view('param.major.index', compact('major'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function data_allMajor()
    {
        $major = Major::all();

        return datatables()::of($major)
        ->addColumn('action', function ($major) {

            return '
            <a href="/param/major/' . $major->id . '/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
            <a href="/param/major/' . $major->id . '" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/param/major/' . $major->id . '"> <i class="fal fa-trash"></i> Delete</button>'
            ;
        })

        ->editColumn('created_at', function ($major) {

            return date(' Y-m-d ', strtotime($major->updated_at) );
        })

        ->make(true);
    }

    public function create()
    {
        return view('param.major.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Major::create($this->validateRequestStore());
        return redirect('param/major');
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'id'               => 'required|min:1|max:255|unique:major,id',                       
            'major_code'       => 'required|min:1|max:255|unique:major,major_code',  
            'major_name'       => 'required|min:1|max:255',    
            'major_status'     => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        $arr['major'] = $major;
        return view('param.major.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        return view('param.major.edit',compact('major'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        $major->update($this->validateRequestUpdate($major));
        return redirect('param/major');
    }

    public function validateRequestUpdate(Major $major)
    {
        return request()->validate([
            'id'               => 'required|min:1|max:255|unique:major,id,'. $major->id,                     
            'major_code'       => 'required|min:1|max:255|unique:major,major_code,'. $major->major_code,
            'major_name'       => 'required|min:1|max:255',    
            'major_status'     => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Major::find($id);
        $exist->delete();
        return response()->json(['success'=>'Major deleted successfully.']);
    }
}

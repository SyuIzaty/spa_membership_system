<?php

namespace App\Http\Controllers;

use App\Programme;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programme = Programme::all();
        return view('param.programme.index', compact('programme'));
    }

    public function data_allProgramme()
    {
        $programmes = Programme::all();

        return datatables()::of($programmes)
        ->addColumn('action', function ($programmes) {

            return '
            <a href="/param/programme/' . $programmes->id . '/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
            <a href="/param/programme/' . $programmes->id . '" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/param/programme/' . $programmes->id . '"> <i class="fal fa-trash"></i> Delete</button>'
            ;
        })

        ->editColumn('created_at', function ($programmes) {

            return date(' Y-m-d ', strtotime($programmes->updated_at) );
        })

        ->make(true);

        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('param.programme.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Programme::create($this->validateRequestStore());
        return redirect('param/programme');

    }

    public function validateRequestStore()
    {
        return request()->validate([
            'id'                   => 'required|min:1|max:255|unique:programmes,id',
            'programme_code'       => 'required|min:1|max:255|unique:programmes,programme_code',
            'programme_name'       => 'required|min:1|max:255',
            'scroll_name'          => 'required|min:1|max:255',
            'programme_name_malay' => 'required|min:1|max:255',
            'scroll_name_malay'    => 'required|min:1|max:255',
            'programme_status'     => 'required',
            'programme_duration'   => 'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show(Programme $programme)
    {
        $arr['programme'] = $programme;
        return view('param.programme.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit(Programme $programme)
    {
        return view('param.programme.edit',compact('programme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Programme $programme)
    {
        $programme->update($this->validateRequestUpdate($programme));
        return redirect('param/programme');
    }

    public function validateRequestUpdate(Programme $programme)
    {
        return request()->validate([
            'id'                   => 'required|min:1|max:255|unique:programmes,id,'. $programme->id,
            'programme_code'       => 'required|min:1|max:255|unique:programmes,programme_code,'. $programme->programme_code,
            'programme_name'       => 'required|min:1|max:255',
            'scroll_name'          => 'required|min:1|max:255',
            'programme_name_malay' => 'required|min:1|max:255',
            'scroll_name_malay'    => 'required|min:1|max:255',
            'programme_status'     => 'required',
            'programme_duration'   => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Programme::find($id);
        $exist->delete();
        return response()->json(['success'=>'Programme deleted successfully.']);
    }
}

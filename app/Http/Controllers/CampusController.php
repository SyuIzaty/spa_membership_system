<?php

namespace App\Http\Controllers;

use Redirect;
use App\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['campus'] = Campus::all();
        return view('space.campus.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('space.campus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Campus::create($this->validateRequestStore());
        return redirect('space/campus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function show(Campus $campus)
    {
        $arr['campus'] = $campus;
        return view('space.campus.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function edit(Campus $campus)
    {
        return view('space.campus.edit',compact('campus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campus $campus)
    {
        //dd($fields);
        $campus->update($this->validateRequestUpdate($campus));
        return redirect('space/campus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campus  $campus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campus $campus)
    {
        $campus->delete();
        return redirect()->route('space.campus.index');
    }

    public function data_campus_list()
    {
        $campus = Campus::select('*');

        return datatables()::of($campus)
        ->addColumn('action', function ($campus) {

            return '<a href="/space/campus/'.$campus->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/campus/'.$campus->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/campus/' . $campus->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:campuses,code',                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'address1'            => 'required',
            'address2'            => '',  
            'postcode'            => 'required',  
            'city'                => 'required', 
            'state_id'            => 'required',  
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Campus $campus)
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:campuses,code,'.$campus->id,                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'address1'            => 'required',
            'address2'            => '',  
            'postcode'            => 'required',  
            'city'                => 'required', 
            'state_id'            => 'required',  
            'active'              => 'required', 
        ]);
    }

}

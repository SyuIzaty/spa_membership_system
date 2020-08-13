<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomsuitability;
use Illuminate\Http\Request;

class RoomSuitabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['roomsuitability'] = Roomsuitability::all();
        return view('space.roomsuitability.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('space.roomsuitability.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Roomsuitability::create($this->validateRequestStore());
        return redirect('space/roomsuitability');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Roomsuitability $roomsuitability)
    {
        $arr['roomsuitability'] = $roomsuitability;
        return view('space.roomsuitability.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Roomsuitability $roomsuitability)
    {
        return view('space.roomsuitability.edit',compact('roomsuitability'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roomsuitability $roomsuitability)
    {
        $roomsuitability->update($this->validateRequestUpdate($roomsuitability));
        return redirect('space/roomsuitability');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roomsuitability $roomsuitability)
    {
        $roomsuitability->delete();
        return redirect()->route('space.roomsuitability.index');
    }

    public function data_roomsuitability_list()
    {
        $roomsuitability = Roomsuitability::select('*');

        return datatables()::of($roomsuitability)
        ->addColumn('action', function ($roomsuitability) {

            return '<a href="/space/roomsuitability/'.$roomsuitability->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/roomsuitability/'.$roomsuitability->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/roomsuitability/' . $roomsuitability->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:roomsuitabilities,code',                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Roomsuitability $roomsuitability)
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:roomsuitabilities,code,'.$roomsuitability->id,                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'active'              => 'required', 
        ]);
    }

}


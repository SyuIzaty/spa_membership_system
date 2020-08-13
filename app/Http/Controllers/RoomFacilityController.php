<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomfacility;
use Illuminate\Http\Request;

class RoomFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['roomfacility'] = Roomfacility::all();
        return view('space.roomfacility.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('space.roomfacility.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Roomfacility::create($this->validateRequestStore());
        return redirect('space/roomfacility');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Roomfacility $roomfacility)
    {
        $arr['roomfacility'] = $roomfacility;
        return view('space.roomfacility.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Roomfacility $roomfacility)
    {
        return view('space.roomfacility.edit',compact('roomfacility'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roomfacility $roomfacility)
    {
        $roomfacility->update($this->validateRequestUpdate($roomfacility));
        return redirect('space/roomfacility');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roomfacility $roomfacility)
    {
        $roomfacility->delete();
        return redirect()->route('space.roomfacility.index');
    }

    public function data_roomfacility_list()
    {
        $roomfacility = Roomfacility::select('*');

        return datatables()::of($roomfacility)
        ->addColumn('action', function ($roomfacility) {

            return '<a href="/space/roomfacility/'.$roomfacility->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/roomfacility/'.$roomfacility->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/roomfacility/' . $roomfacility->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:roomfacilities,code',                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Roomfacility $roomfacility)
    {
        return request()->validate([
            'code'                => 'required|min:3|max:10|unique:roomfacilities,code,'.$roomfacility->id,                        
            'name'                => 'required|min:3|max:100',  
            'description'         => 'required|min:5|max:1000',    
            'active'              => 'required', 
        ]);
    }

}

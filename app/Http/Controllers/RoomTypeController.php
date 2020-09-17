<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomtype;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr['roomtype'] = Roomtype::all();
        return view('space.roomtype.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('space.roomtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Roomtype::create($this->validateRequestStore());
        return redirect('space/roomtype');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Roomtype $roomtype)
    {
        $arr['roomtype'] = $roomtype;
        return view('space.roomtype.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Roomtype $roomtype)
    {
        return view('space.roomtype.edit',compact('roomtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roomtype $roomtype)
    {
        $roomtype->update($this->validateRequestUpdate($roomtype));
        return redirect('space/roomtype');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roomtype $roomtype)
    {
        $roomtype->delete();
        return redirect()->route('space.roomtype.index');
    }
    
    public function data_roomtype_list()
    {
        $roomtype = Roomtype::select('*');

        return datatables()::of($roomtype)
        ->addColumn('action', function ($roomtype) {

            return '<a href="/space/roomtype/'.$roomtype->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/roomtype/'.$roomtype->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/roomtype/' . $roomtype->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'code'                => 'required|min:1|max:10|unique:room_types,code',                        
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Roomtype $roomtype)
    {
        return request()->validate([
            'code'                => 'required|min:1|max:10|unique:room_types,code,'.$roomtype->id,                        
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

}

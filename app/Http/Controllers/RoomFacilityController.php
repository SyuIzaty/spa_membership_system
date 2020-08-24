<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomfacility;
use App\Roomtype;
use App\Roomsuitability;
use Illuminate\Http\Request;

class RoomFacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Roomfacility $roomfacility)
    {
        $arr['roomfacility'] = $roomfacility;
        $arr['roomtype'] = Roomtype::all();
        $arr['roomsuitability'] = Roomsuitability::all();
        return view('space.roomfacility.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roomtype = Roomtype::where('active', 1)->get();
        $roomsuitability = Roomsuitability::where('active', 1)->get();
        $roomfacility = new Roomfacility();
        return view('space.roomfacility.create', compact('roomtype', 'roomsuitability', 'roomfacility'));
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
        $arr['roomtype'] = Roomtype::all();
        $arr['roomsuitability'] = Roomsuitability::all();
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
        $arr['roomfacility'] = $roomfacility;
        $arr['roomtype'] = Roomtype::where('active', 1)->get();
        $arr['roomsuitability'] = Roomsuitability::where('active', 1)->get();
        return view('space.roomfacility.edit')->with($arr);
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
    public function destroy($id)
    {
        $roomfacility = Roomfacility::find($id);
        $roomfacility->delete();
        return Redirect::route('space.roomfacility.index');
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

        ->editColumn('roomtype_id', function ($roomfacility) {
            
            return $roomfacility->roomtype->name;
          
        })

        ->editColumn('roomsuitability_id', function ($roomfacility) {
            
            return $roomfacility->roomsuitability->name;
          
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'code'                => 'required|min:1|max:10|unique:roomfacilities,code',                        
            'roomtype_id'         => 'required',  
            'roomsuitability_id'  => 'required',          
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Roomfacility $roomfacility)
    {
        return request()->validate([
            'code'                => 'required|min:1|max:10|unique:roomfacilities,code,'.$roomfacility->id,                        
            'roomtype_id'         => 'required',  
            'roomsuitability_id'  => 'required',          
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function findroomsuitability(Request $request){ //RSuitability
        $data = Roomsuitability::select('name', 'id')
                ->where('roomtype_id',$request->id)
                ->where('active', 1)
                ->take(100)->get();

        return response()->json($data);
    }

}

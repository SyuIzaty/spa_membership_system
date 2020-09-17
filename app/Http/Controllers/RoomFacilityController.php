<?php

namespace App\Http\Controllers;

use Redirect;
use App\Roomfacility;
use App\Roomtype;
use App\Roomsuitability;
use App\Storefacility;
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
        $arr['roomtype'] = Roomtype::all();
        $arr['roomsuitability'] = Roomsuitability::all();
        $arr['roomfacility']  = Roomfacility::with('store_facilities')->get(); 
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
        $request->validate([
            'code'                => 'required|min:1|max:10|unique:room_facilities,code',                        
            'roomtype_id'         => 'required',  
            'roomsuitability_id'  => 'required',          
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);

        $roomsuit = $request->input('roomsuitability_id');
        $roomsuit = implode(',', $roomsuit);
        $input = $request->except('roomsuitability_id');
        $input['roomsuitability_id'] = $roomsuit; 
        $input['roomtype_id'] = $request->roomtype_id; 
        $room = Roomfacility::create($input);

        foreach (explode(',', $input['roomsuitability_id']) as $input)
        {
            $storefacility = new Storefacility(); 
            $storefacility->roomfacility_id = $room->id; 
            $storefacility->roomtype_id = $request->roomtype_id;
            $storefacility->roomsuitability_id = $input;
            $storefacility->save();
        }

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
        $arr['roomtype'] = Roomtype::all();
        $arr['roomsuitability'] = Roomsuitability::all();

        // $d = explode(',', $roomfacility['roomsuitability_id']);

        // foreach(explode(',', $roomfacility['roomsuitability_id']) as $input)
        // {
        //     $name[] = Roomsuitability::select('name')->where('id', $input)->first();
        // }

        // $arr['name'] = $name;

        // @

        $roomfacility = Roomfacility::with('store_facilities')->where('id', $roomfacility->id)->first(); 
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
    public function update(Request $request, Storefacility $storefacility, $id)
    {
        $this->validate($request,[
            'code'                => 'required|min:1|max:10|unique:room_facilities,code,'.$id,                        
            'roomtype_id'         => 'required',  
            'roomsuitability_id'  => 'required',          
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);

        $roomsuit = $request->input('roomsuitability_id');
        $roomsuit = implode(',', $roomsuit);
        $input = $request->except('roomsuitability_id');
        $input['roomsuitability_id'] = $roomsuit; 
        $input['roomtype_id'] = $request->roomtype_id; 
        $room = Roomfacility::find($id);
        $room->update($input);

        // $storefacility = Storefacility::where('roomfacility_id', $room->id);
        // $storefacility->delete();
        Storefacility::where('roomfacility_id', $room->id)->delete();

        foreach (explode(',', $input['roomsuitability_id']) as $input) 
        {
            $storefacility = new Storefacility;
            $storefacility->roomfacility_id = $room->id; 
            $storefacility->roomtype_id = $request->roomtype_id;
            // $storefacility->roomsuitability_id = $request->get('roomsuitability_id[]');
            $storefacility->roomsuitability_id = $input;
            $storefacility->save();
        }

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

            $room_name = '';
            
            foreach($roomfacility['store_facilities'] as $roomsuitability)
            {
                $room_name .= "<ul><li>".$roomsuitability->roomsuitability->name."</li></ul>";
            }
            
            return $room_name;
          
        })

        ->rawColumns(['roomsuitability_id', 'action']) //use rawColumns to allow rendering of html
            
        ->make(true);
    }

    public function findroomsuitability(Request $request){ 
        $data = Roomsuitability::select('name', 'id')
                ->where('roomtype_id',$request->id)
                ->where('active', 1)
                ->take(100)->get();

        return response()->json($data);
    }

}

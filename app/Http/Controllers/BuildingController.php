<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Zone;
use App\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Building $building)
    {
        $arr['building'] = $building;
        $arr['zone'] = Zone::all(); //use zone model
        $arr['campus'] = Campus::all(); //use campus model
        return view('space.building.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zone = Zone::where('active', 1)->get();
        $campus = Campus::where('active', 1)->get();
        $building = new Building();
        return view('space.building.create', compact('zone', 'campus', 'building'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Building::create($this->validateRequestStore());
        return redirect('space/building');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        $arr['building'] = $building;
        $arr['zone'] = Zone::all();
        $arr['campus'] = Campus::all();
        return view('space.building.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        $arr['building'] = $building;
        $arr['zone'] = Zone::where('active', 1)->get();
        $arr['campus'] = Campus::where('active', 1)->get();
        return view('space.building.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Building $building)
    {
        $building->update($this->validateRequestUpdate($building));
        return redirect('space/building');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $building = Building::find($id);
        $building->delete();
        return Redirect::route('space.building.index');
    }

    public function data_building_list() 
    {
        $building = Building::select('*');
        
        return datatables()::of($building)
        ->addColumn('action', function ($building) {

            return '<a href="/space/building/'.$building->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/building/'.$building->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/building/' . $building->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

        ->editColumn('campus_id', function ($building) {
            
            return $building->campus->name;
          
        })

        ->editColumn('zone_id', function ($building) {
            
            return $building->zone->name;
          
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'building_code'       => 'required|min:1|max:10|unique:buildings,building_code',   
            'campus_id'           => 'required',  
            'zone_id'             => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Building $building)
    {
        return request()->validate([
            'building_code'       => 'required|min:1|max:10|unique:buildings,building_code,'.$building->id,   
            'campus_id'           => 'required',  
            'zone_id'             => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function findzoneid(Request $request){ //Building $building
        $data = Zone::select('name', 'id')
                ->where('campus_id',$request->id)
                ->where('active', 1)
                ->take(100)->get();

        return response()->json($data);
    }

}

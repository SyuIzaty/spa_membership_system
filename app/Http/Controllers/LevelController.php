<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Zone;
use App\Building;
use App\Level;
// use Redirect;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\View;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Level $level)
    {
        $arr['level'] = $level;
        $arr['building'] = Building::all(); //use building model
        $arr['zone'] = Zone::all(); //use zone model
        $arr['campus'] = Campus::all(); //use campus model
        return view('space.level.index')->with($arr);
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
        $building = Building::where('active', 1)->get();
        $level = new Level();
        return view('space.level.create', compact('zone', 'campus', 'building','level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Level::create($this->validateRequestStore());
        return redirect('space/level');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        $arr['level'] = $level;
        $arr['building'] = Building::all();
        $arr['zone'] = Zone::all();
        $arr['campus'] = Campus::all();
        return view('space.level.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        $arr['level'] = $level;
        $arr['building'] = Building::where('active', 1)->get();
        $arr['zone'] = Zone::where('active', 1)->get();
        $arr['campus'] = Campus::where('active', 1)->get();
        return view('space.level.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        $level->update($this->validateRequestUpdate($level));
        return redirect('space/level');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $level = Level::find($id);
        $level->delete();
        return Redirect::route('space.level.index');
    }

    public function data_level_list() 
    {
        $level = Level::select('*');
        
        return datatables()::of($level)
        ->addColumn('action', function ($level) {

            return '<a href="/space/level/'.$level->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/level/'.$level->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/level/' . $level->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

        ->editColumn('campus_id', function ($level) {
            
            return $level->campus->name;
          
        })

        ->editColumn('zone_id', function ($level) {
            
            return $level->zone->name;
          
        })

        ->editColumn('building_id', function ($level) {
            
            return $level->building->name;
          
        })
        
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'level_code'          => 'required|min:1|max:10|unique:levels,level_code',   
            'campus_id'           => 'required',  
            'zone_id'             => 'required', 
            'building_id'         => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Level $level)
    {
        return request()->validate([
            'level_code'          => 'required|min:1|max:10|unique:levels,level_code,'.$level->id,   
            'campus_id'           => 'required',  
            'zone_id'             => 'required', 
            'building_id'         => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function findzone(Request $request){ 
        $data = Zone::select('name','id')
                ->where('campus_id',$request->id)
                ->where('active', 1)
                ->take(100)->get();

        return response()->json($data);
    }

    public function findbuilding(Request $request){ 
        $data2 = Building::select('name','id')
                ->where('zone_id',$request->id)
                ->where('active', 1)
                ->take(100)->get();

        return response()->json($data2);
    }

}


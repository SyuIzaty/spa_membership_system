<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Zone;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Zone $zone) 
    {
        $arr['zone'] = $zone;
        $arr['campus'] = Campus::all();
        return view('space.zone.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        $campus = Campus::where('active', 1)->get();
        $zone = new Zone();
        return view('space.zone.create', compact('campus', 'zone'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        Zone::create($this->validateRequestStore());
        return redirect('space/zone');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone) 
    {
        $arr['zone'] = $zone;
        $arr['campus'] = Campus::all();
        return view('space.zone.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone) 
    {
        $arr['zone'] = $zone;
        $arr['campus'] = Campus::where('active', 1)->get();
        return view('space.zone.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone) 
    {
        $zone->update($this->validateRequestUpdate($zone));
        return redirect('space/zone');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        $zone = Zone::find($id);
    	$zone->delete();
    	return Redirect::route('space.zone.index');
    }

    public function data_zone_list() 
    {
        $zone = Zone::select('*');
        
        return datatables()::of($zone)
        ->addColumn('action', function ($zone) {

            return '<a href="/space/zone/'.$zone->id.'/edit" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i> Edit</a>
                    <a href="/space/zone/'.$zone->id.'" class="btn btn-sm btn-info btn-view"><i class="fal fa-eye"></i> View</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/space/zone/' . $zone->id . '"><i class="fal fa-trash"></i> Delete</button>';
        })

         ->editColumn('campus_id', function ($zone) {
            
            return $zone->campus->name;
          
        })
            
        ->make(true);
    }

    public function validateRequestStore()
    {
        return request()->validate([
            'zone_code'           => 'required|min:1|max:10|unique:zones,zone_code',   
            'campus_id'           => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

    public function validateRequestUpdate(Zone $zone)
    {
        return request()->validate([
            'zone_code'           => 'required|min:1|max:10|unique:zones,zone_code,'.$zone->id,   
            'campus_id'           => 'required',                    
            'name'                => 'required|min:1|max:100',  
            'description'         => 'required|min:1|max:1000',    
            'active'              => 'required', 
        ]);
    }

}

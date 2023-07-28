<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreVenueRequest;
use App\SpaceStatus;
use App\SpaceVenue;
use DataTables;

class VenueDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = SpaceStatus::Main()->get();
        $student = SpaceStatus::Student()->get();
        $venue = SpaceVenue::with('spaceStatus')->select('space_venues.*');
        if($request->ajax()) {
        return DataTables::of($venue)
            ->addColumn('venue_status', function($venue){
                return isset($venue->spaceStatus->name) ? $venue->spaceStatus->name : '';
            })
            ->addColumn('open_to_student', function($venue){
                return isset($venue->openStudent->name) ? $venue->openStudent->name : '';
            })
            ->addColumn('action', function($venue){
                return
                '
                <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$venue->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/venue-management/' . $venue->id . '"> <i class="fal fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.venue.index',compact('venue','status','student'));
    }

    public function getVenueDetail(Request $request)
    {
        $venue = SpaceVenue::find($request->id);
        echo json_encode($venue);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVenueRequest $request)
    {
        SpaceVenue::create([
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'open_student' => ($request->open_student == 'on') ? 7 : 8,
            'status' => ($request->status == 'on') ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVenueRequest $request, $id)
    {
        // dd($request->all());
        // if($request->open_student == 'on'){
        //     dd('yes');
        // }else{
        //     dd('no');
        // }
        SpaceVenue::where('id',$request->venue_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'maximum' => $request->maximum,
            'open_student' => ($request->open_student == 'on') ? 7 : 8,
            'status' => ($request->status == 'on') ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SpaceVenue::where('id',$id)->delete();
    }
}

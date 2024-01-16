<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FacilityRoomType;
use DataTables;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = FacilityRoomType::with('facilityStatus')->select('facility_room_types.*');
        if($request->ajax()) {
        return DataTables::of($type)
            ->addColumn('type_status', function($type){
                return isset($type->facilityStatus->name) ? $type->facilityStatus->name : '';
            })
            ->addColumn('action', function($type){
                return
                '
                <a href="javascript:;" data-toggle="modal" class="btn btn-primary btn-sm new"><i class="fal fa-pencil"></i></a>
                <button class="btn btn-danger btn-sm"><i class="fal fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('space.space-setting.room-type.index',compact('type'));
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

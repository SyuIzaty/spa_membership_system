<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FacilityRoomType;
use App\FacilityBlock;
use App\FacilityRoom;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $block = FacilityBlock::all();
        $type = FacilityRoomType::all();
        return view('space.space-setting.report.index',compact('block','type'));
    }

    public function data_spacereport(Request $request)
    {
        $cond = "1";

        if($request->block_id && $request->block_id != "All")
        {
            $cond .= " AND (block_id = '".$request->block_id."')";
        }
        if($request->status_id && $request->status_id != "All")
        {
            $cond .= " AND (status_id = '".$request->status_id."')";
        }
        if($request->room_type && $request->room_type != "All")
        {
            $cond .= " AND (room_id = '".$request->room_type."')";
        }

        $room = FacilityRoom::whereRaw($cond)->with('facilityBlock','facilityRoomType','facilityStatus')->select('facility_rooms.*');

        return datatables()::of($room)
            ->addColumn('block_name',function($room)
            {
                return isset($room->facilityBlock->name) ? $room->facilityBlock->name : '';
            })
            ->addColumn('type_name',function($room)
            {
                return isset($room->facilityRoomType->name) ? $room->facilityRoomType->name : '';
            })
            ->addColumn('status_name',function($room)
            {
                return isset($room->facilityStatus->name) ? $room->facilityStatus->name : '';
            })
        //    ->rawColumns(['prog_name','prog_name_2','prog_name_3','address','college'])
           ->make(true);
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

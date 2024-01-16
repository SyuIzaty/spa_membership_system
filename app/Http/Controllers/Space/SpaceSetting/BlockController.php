<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FacilityBlock;
use App\FacilityRoom;
use DataTables;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $block = FacilityBlock::with('facilityStatus')->select('facility_blocks.*');
        if($request->ajax()) {
        return DataTables::of($block)
            ->addColumn('block_status', function($block){
                return isset($block->facilityStatus->name) ? $block->facilityStatus->name : '';
            })
            ->addColumn('action', function($block){
                if($block->facilityRooms->count() >= 1){
                    return
                    '
                    <a href="/space/space-setting/block/'.$block->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
                    ';
                }else{
                    return
                    '
                    <a href="/space/space-setting/block/'.$block->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/block/' . $block->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.space-setting.block.index',compact('block'));
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
        $request->validate([
            'block_name' => 'required',
        ]);

        FacilityBlock::create([
            'name' => $request->block_name,
            'status_id' => isset($request->block_status) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Data Created');
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
    public function edit($id, Request $request)
    {
        $open = FacilityRoom::StatusId(1)->BlockId($id)->count();
        $closed = FacilityRoom::StatusId(2)->BlockId($id)->count();
        $room = FacilityRoom::BlockId($id)->with('facilityRoomType','facilityStatus','facilityBlock')->select('facility_rooms.*');
        if($request->ajax()) {
        return DataTables::of($room)
            ->addColumn('room_block', function($room){
                return isset($room->facilityBlock->name) ? $room->facilityBlock->name : '';
            })
            ->addColumn('room_name', function($room){
                return isset($room->facilityRoomType->name) ? $room->facilityRoomType->name : '';
            })
            ->addColumn('room_status', function($room){
                return isset($room->facilityStatus->name) ? $room->facilityStatus->name : '';
            })
            ->addColumn('action', function($room){
                return
                '
                <a href="/space/space-setting/room/'.$room->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
                <button class="btn btn-danger btn-sm"><i class="fal fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('space.space-setting.room.index',compact('open','closed'));
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
        FacilityBlock::where('id',$id)->delete();
    }
}

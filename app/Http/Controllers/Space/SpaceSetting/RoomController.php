<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AssetType;
use App\Asset;
use App\Stock;
use App\SpaceRoom;
use App\SpaceBlock;
use App\SpaceItem;
use App\SpaceItemMain;
use App\SpaceCategory;
use App\SpaceRoomType;
use App\DepartmentList;
use DataTables;
use Carbon\Carbon;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
            'room_type' => 'required',
            'block_id' => 'required',
        ]);

        $block = SpaceBlock::find($request->block_id);
        $type = SpaceRoomType::find($request->room_type);
        $room = SpaceRoom::BlockId($request->block_id)->RoomId($request->room_type)
        ->FloorId($request->room_floor)->count()+1;
        if($type->enable_generate == 11){
            if(isset($request->room_name)){
                $name = $request->room_name;
            }else{
                $name = substr($type->name, 0, 2).''.substr($block->name, -1).''.$request->room_floor.''.str_pad($room, 2, '0', STR_PAD_LEFT);
            }
        }else{
            $name = $request->room_name;
        }
        
        $room_id = SpaceRoom::insertGetId([
            'block_id' => $request->block_id,
            'room_id' => $request->room_type,
            'floor' => $request->room_floor,
            'name' => $name,
            'description' => $request->room_description,
            'capacity' => $request->room_capacity,
            'status_id' => isset($request->room_status) ? 9 : 10,
            'remark' => $request->room_remark,
            'created_at' => Carbon::now(),
        ]);

        if(isset($request->item_id)){
            foreach($request->item_id as $key => $value){
                $item_category = explode('-',$value);
                SpaceItem::create([
                    'room_id' => $room_id,
                    'item_category' => $item_category[1],
                    'item_id' => $item_category[0],
                    'asset_id' => $value,
                    'quantity' => $request->item_quantity[$key],
                    'name' => $request->item_name[$key],
                    'serial_no' => $request->item_serial[$key],
                    'description' => $request->item_remark[$key],
                    'status' => $request->item_status[$key]
                ]);
            }
        }

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
        $type = SpaceRoomType::StatusId(9)->get();
        $asset = AssetType::all();
        $category = SpaceCategory::all();

        return view('space.space-setting.room.create',compact('id','type','asset','category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = SpaceRoom::find($id);
        $type = SpaceRoomType::all();
        $item = SpaceItem::RoomId($id)->get();
        $department = DepartmentList::all();
        $asset = AssetType::all();
        $category = SpaceCategory::all();

        return view('space.space-setting.room.edit',compact('room','type','item','asset','category','department'));
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
        SpaceRoom::where('id',$id)->update([
            'room_id' => $request->room_type,
            'floor' => $request->room_floor,
            'name' => $request->room_name,
            'description' => $request->room_description,
            'capacity' => $request->room_capacity,
            'status_id' => isset($request->status) ? 9 : 10,
            'remark' => $request->remark,
        ]);

        if(isset($request->asset_id)){
            foreach($request->asset_id as $key => $value){
                $item_category = explode('-',$value);
                SpaceItem::where('id',$key)->update([
                    'item_category' => $item_category[1],
                    'item_id' => $item_category[0],
                    'serial_no' => $request->item_serial[$key],
                    'name' => $request->item_name[$key],
                    'description' => $request->item_description[$key],
                    'quantity' => $request->item_quantity[$key],
                    'status' => $request->item_status[$key],
                ]);
            }
        }

        return redirect()->back()->with('message','Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SpaceRoom::where('id',$id)->delete();
    }
}

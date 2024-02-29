<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Space\SpaceItemImport;
use App\SpaceRoomType;
use App\SpaceCategory;
use App\SpaceBlock;
use App\SpaceMain;
use App\SpaceRoom;
use App\AssetType;
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
        $main = SpaceMain::Active()->get();
        $block = SpaceBlock::with('spaceStatus','spaceRooms','spaceMain')->select('space_blocks.*');
        if($request->ajax()) {
        return DataTables::of($block)
            ->addColumn('category_id', function($block){
                return isset($block->spaceMain->name) ? $block->spaceMain->name : '';
            })
            ->addColumn('block_status', function($block){
                return isset($block->spaceStatus->name) ? $block->spaceStatus->name : '';
            })
            ->addColumn('room_total', function($block){
                return $block->spaceRooms->count();
            })
            ->addColumn('action', function($block){
                if($block->spaceRooms->count() >= 1){
                    return
                    '
                    <a href="/space/space-setting/block/'.$block->id.'/edit" class="btn btn-info btn-sm"><i class="fal fa-list"></i></a>
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$block->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    ';
                }else{
                    return
                    '
                    <a href="/space/space-setting/block/'.$block->id.'/edit" class="btn btn-info btn-sm"><i class="fal fa-list"></i></a>
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$block->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/block/' . $block->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.space-setting.block.index',compact('block','main'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room_type = SpaceRoomType::all();
        $asset = AssetType::all();
        $category = SpaceCategory::all();
        return view('space.space-setting.block.create',compact('room_type','asset','category'));
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
            'category' => 'required',
        ]);

        SpaceBlock::create([
            'name' => $request->block_name,
            'main_id' => $request->category,
            'status_id' => isset($request->block_status) ? 9 : 10,
        ]);

        return redirect()->back()->with('message','Data Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $block = SpaceBlock::find($request->id);
        echo json_encode($block);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $block = SpaceBlock::find($id);
        $open = SpaceRoom::StatusId(9)->BlockId($id)->count();
        $closed = SpaceRoom::StatusId(10)->BlockId($id)->count();
        $room = SpaceRoom::BlockId($id)->with('spaceRoomType','spaceStatus','spaceBlock')->select('space_rooms.*');
        if($request->ajax()) {
        return DataTables::of($room)
            ->addColumn('room_block', function($room){
                return isset($room->spaceBlock->name) ? $room->spaceBlock->name : '';
            })
            ->addColumn('room_name', function($room){
                return isset($room->spaceRoomType->name) ? $room->spaceRoomType->name : '';
            })
            ->addColumn('room_status', function($room){
                return isset($room->spaceStatus->name) ? $room->spaceStatus->name : '';
            })
            ->addColumn('action', function($room){
                return
                '
                <a href="/space/space-setting/room/'.$room->id.'/edit" class="btn btn-primary btn-sm"><i class="fal fa-pencil"></i></a>
                <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/room/' . $room->id . '"> <i class="fal fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('space.space-setting.room.index',compact('open','closed','id','block'));
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
        $request->validate([
            'block_name' => 'required',
            'category' => 'required',
        ]);

        SpaceBlock::where('id',$request->block_id)->update([
            'name' => $request->block_name,
            'main_id' => $request->category,
            'status_id' => isset($request->status) ? 9 : 10,
        ]);

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
        SpaceBlock::where('id',$id)->delete();
    }

    public function blockTemplate()
    {
        return Storage::disk('minio')->response('space/BLOCK & ITEM.xlsx');
    }

    public function uploadBlock(Request $request)
    {
        $this->validate($request, [
            'upload_block' => 'required|mimes:xlsx, csv, xls',
        ]);

        Excel::import(new SpaceItemImport(), request()->file('upload_block'));

        return back()->with('success','Space & Item Imported');
    }
}

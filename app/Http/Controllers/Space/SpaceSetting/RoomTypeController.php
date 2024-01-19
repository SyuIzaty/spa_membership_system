<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpaceRoomType;
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
        $type = SpaceRoomType::with('spaceStatus')->select('space_room_types.*');
        if($request->ajax()) {
        return DataTables::of($type)
            ->addColumn('type_status', function($type){
                return isset($type->spaceStatus->name) ? $type->spaceStatus->name : '';
            })
            ->addColumn('action', function($type){
                if($type->spaceRooms->count() >= 1){
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$type->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    ';
                }else{
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$type->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/room-type/' . $type->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                }
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
        $request->validate([
            'room_name' => 'required',
            'room_description' => 'required',
        ]);

        SpaceRoomType::create([
            'name' => $request->room_name,
            'description' => $request->room_description,
            'enable_generate' => isset($request->room_enable) ? 11 : 12,
            'status_id' => isset($request->room_status) ? 9 : 10,
        ]);

        return redirect()->back()->with('message','Data Added');
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
        $type = SpaceRoomType::find($request->id);
        echo json_encode($type);
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
            'room_name' => 'required',
            'room_description' => 'required',
        ]);

        SpaceRoomType::where('id',$request->type_id)->update([
            'name' => $request->room_name,
            'description' => $request->room_description,
            'status_id' => isset($request->status) ? 9 : 10,
            'enable_generate' => isset($request->enable) ? 11 : 12,
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
        SpaceRoomType::where('id',$id)->delete();
    }
}

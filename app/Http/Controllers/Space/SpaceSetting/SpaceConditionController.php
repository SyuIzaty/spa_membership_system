<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpaceCondition;
use DataTables;

class SpaceConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = SpaceCondition::with('spaceStatus')->select('space_conditions.*');
        if($request->ajax()) {
        return DataTables::of($type)
            ->addColumn('type_status', function($type){
                return isset($type->spaceStatus->name) ? $type->spaceStatus->name : '';
            })
            ->addColumn('action', function($type){
                if($type->spaceRoomConditions->count() >= 1){
                    return
                        '
                        <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$type->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                        ';
                    
                }else{
                    return
                        '
                        <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$type->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/space-condition/' . $type->id . '"> <i class="fal fa-trash"></i></button>
                        ';

                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('space.space-setting.space-condition.index');
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
            'name' => 'required',
            'description' => 'required',
        ]);

        SpaceCondition::create([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => isset($request->status) ? 1 : 2,
        ]);

        return redirect()->back()->with('message','Added');
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
        $condition = SpaceCondition::find($request->id);
        echo json_encode($condition);
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
            'name' => 'required',
            'description' => 'required',
        ]);

        SpaceCondition::where('id',$request->condition_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'status_id' => isset($request->status) ? 1 : 2,
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
        SpaceCondition::where('id',$id)->delete();
    }
}

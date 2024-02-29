<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpaceMain;
use DataTables;

class SpaceMainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $block = SpaceMain::with('spaceStatus')->select('space_mains.*');
        if($request->ajax()) {
        return DataTables::of($block)
            ->addColumn('main_status', function($block){
                return isset($block->spaceStatus->name) ? $block->spaceStatus->name : '';
            })
            ->addColumn('action', function($block){
                if($block->spaceBlocks->count() >= 1){
                    return
                        '
                        <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$block->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                        ';
                }else{
                    return
                        '
                        <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$block->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/space-setting/space-main/' . $block->id . '"> <i class="fal fa-trash"></i></button>
                        ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.space-setting.space-main.index');
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
            'category_name' => 'required',
        ]);

        SpaceMain::create([
            'name' => $request->category_name,
            'status' => isset($request->status) ? 9 : 10,
        ]);

        return redirect()->back()->with('message','Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $main = SpaceMain::find($request->id);
        echo json_encode($main);
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
        $request->validate([
            'category_name' => 'required',
        ]);

        SpaceMain::where('id',$request->category_id)->update([
            'name' => $request->category_name,
            'status' => isset($request->status) ? 9 : 10,
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
        SpaceMain::where('id',$id)->delete();
    }
}

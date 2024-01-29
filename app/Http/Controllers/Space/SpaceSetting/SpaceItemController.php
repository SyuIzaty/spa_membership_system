<?php

namespace App\Http\Controllers\Space\SpaceSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpaceItem;

class SpaceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'room_id' => 'required',
            'item_id' => 'required',
        ]);
        
        $item_id = explode('-',$request->item_id);
        SpaceItem::create([
            'room_id' => $request->room_id,
            'item_id' => $item_id[0],
            'item_category' => $item_id[1],
            'item_serial' => isset($request->item_serial) ? $request->item_serial: '',
            'name' => isset($request->item_name) ? $request->item_name : '',
            'description' => $request->item_description,
            'quantity' => $request->item_quantity,
            'department_id' => $request->department_id,
            'status' => isset($request->item_status) ? 1 : 2,
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
        SpaceItem::where('id',$id)->delete();
    }
}

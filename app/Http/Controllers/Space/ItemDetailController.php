<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreItemRequest;
use App\SpaceStatus;
use App\SpaceItem;
use DataTables;

class ItemDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = SpaceStatus::Main()->get();
        $item = SpaceItem::with('spaceStatus')->select('space_items.*');
        if($request->ajax()) {
        return DataTables::of($item)
            ->addColumn('venue_status', function($item){
                return isset($item->spaceStatus->name) ? $item->spaceStatus->name : '';
            })
            ->addColumn('action', function($item){
                return
                '
                <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$item->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/item-management/' . $item->id . '"> <i class="fal fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.item.index',compact('item','status'));
    }

    public function getItemDetail(Request $request)
    {
        $item = SpaceItem::find($request->id);
        echo json_encode($item);
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
    public function store(StoreItemRequest $request)
    {
        SpaceItem::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'status' => $request->status,
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
    public function update(StoreItemRequest $request, $id)
    {
        SpaceItem::where('id',$request->item_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('message','Created');
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

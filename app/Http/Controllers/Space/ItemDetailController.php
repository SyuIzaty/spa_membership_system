<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreItemRequest;
use App\DepartmentList;
use App\SpaceBookingItem;
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
        $department = DepartmentList::whereIn('id',[1,10,11])->get();
        $item = SpaceItem::with('spaceStatus','departmentList')->select('space_items.*');
        if($request->ajax()) {
        return DataTables::of($item)
            ->addColumn('venue_status', function($item){
                return isset($item->spaceStatus->name) ? $item->spaceStatus->name : '';
            })
            ->addColumn('department_name', function($venue){
                return isset($venue->departmentList->name) ? $venue->departmentList->name : '';
            })
            ->addColumn('action', function($item){
                if($item->spaceBookingItems->count() >= 1){
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$item->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    ';
                }else{
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$item->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/item-management/' . $item->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.item.index',compact('item','status','department'));
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
            'department_id' => $request->department_id,
            'status' => ($request->status == 'on') ? 1 : 2,
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
        $check = SpaceBookingItem::where('item_id',$request->item_id)->count();
        $item = SpaceItem::find($request->item_id);
        SpaceItem::where('id',$request->item_id)->update([
            'name' => ($check >= 1) ? $item->name : $request->name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'department_id' => $request->department_id,
            'status' => ($request->status == 'on') ? 1 : 2,
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
        SpaceItem::where('id',$id)->delete();
    }
}

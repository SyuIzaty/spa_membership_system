<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetType;
use App\AssetCustodian;
use App\AssetDepartment;
use App\Asset;
use Session;
use Auth;
use DB;

class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $assetType = AssetType::where('id', $request->id)->first();
        
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $department = AssetDepartment::all();
        }
        else
        {
            $department = AssetDepartment::whereHas('custodians', function($query){
                $query->where('custodian_id', Auth::user()->id);
            })->get();
        }

        return view('inventory.asset-type.index', compact('assetType', 'department'));
    }

    public function data_asset()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $assetType = AssetType::all();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

            $assetType = AssetType::whereHas('department', function($q) use ($as){
                $q->whereIn('department_id', $as);
            })->get();
        }

        return datatables()::of($assetType)
        ->addColumn('action', function ($assetType) {

            $exist = Asset::where('asset_type', $assetType->id)->first();
            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-type="'.$assetType->id.'" data-department="'.$assetType->department_id.'" data-asset="'.$assetType->asset_type.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-type="'.$assetType->id.'" data-department="'.$assetType->department_id.'" data-asset="'.$assetType->asset_type.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-type/' . $assetType->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->editColumn('department_id', function ($assetType) {

            return strtoupper($assetType->department->department_name) ?? '--';
        })
        
        ->addIndexColumn()
        ->make(true);
    }

    public function addType(Request $request)
    {
        $assetType = AssetType::where('id', $request->id)->first();

        $request->validate([
            'department_id'   => 'required',
            'asset_type'      => 'required|max:255',
        ]);

        AssetType::create([
                'department_id'     => $request->department_id,
                'asset_type'        => $request->asset_type, 
            ]);
        
        Session::flash('message', 'Asset Type Successfully Added');
        return redirect('asset-type');
    }

    public function updateType(Request $request) 
    {
        $assetType = AssetType::where('id', $request->type_id)->first();
        
        $request->validate([
            'asset_type'      => 'required|max:255',
        ]);

        $assetType->update([
            'asset_type'    => $request->asset_type, 
        ]);
        
        Session::flash('notification', 'Asset Type Successfully Updated');
        return redirect('asset-type');
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
        $exist = AssetType::find($id);
        $exist->delete();
        return response()->json(['success'=>'Asset Type Successfully Deleted']);
    }
}

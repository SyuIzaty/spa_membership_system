<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetClass;
use App\Asset;
use Session;
use Auth;
use DB;

class AssetClassController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        return view('inventory.asset-class.index');
    }

    public function data_asset_class()
    {
        $assetClass = AssetClass::all();
         
        return datatables()::of($assetClass)
        ->addColumn('action', function ($assetClass) {

            $exist = Asset::where('asset_class', $assetClass->class_code)->first();
            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-code="'.$assetClass->class_code.'" data-name="'.$assetClass->class_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-code="'.$assetClass->class_code.'" data-name="'.$assetClass->class_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-class/' . $assetClass->class_code . '"><i class="fal fa-trash"></i></button></div>';
            }
        })
        
        ->addIndexColumn()
        ->make(true);
    }

    public function addClass(Request $request)
    {
        $request->validate([
            'class_code'   => 'required',
            'class_name'   => 'required',
        ]);

        AssetClass::create([
                'class_code'     => strtoupper($request->class_code),
                'class_name'     => strtoupper($request->class_name), 
            ]);
        
        Session::flash('message', 'Asset Class Successfully Added');
        return redirect('asset-class');
    }

    public function updateCLass(Request $request) 
    {
        $assetClass = AssetClass::where('class_code', $request->class_id)->first();
        
        $request->validate([
            'class_codes'   => 'required',
            'class_names'   => 'required',
        ]);

        $assetClass->update([
            'class_code'     => strtoupper($request->class_codes),
            'class_name'     => strtoupper($request->class_names), 
        ]);
        
        Session::flash('notification', 'Asset Class Successfully Updated');
        return redirect('asset-class');
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
        $exist = AssetClass::find($id);
        $exist->delete();
        return response()->json(['success'=>'Asset Class Successfully Deleted']);
    }
}

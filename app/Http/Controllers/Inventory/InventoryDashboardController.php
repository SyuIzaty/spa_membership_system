<?php

namespace App\Http\Controllers\Inventory;

use App\AssetType;
use App\AssetStatus;
use App\AssetCustodian;
use App\AssetAcquisition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InventoryDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assetCustodian = AssetCustodian::groupBy('department_id')->pluck('department_id');

        $assetType = AssetType::orderBy('asset_type')->get();

        $assetStatus = AssetStatus::all();

        $assetAcquisition = AssetAcquisition::all();

        return view('inventory.dashboard', compact('assetCustodian','assetType', 'assetStatus', 'assetAcquisition'));
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
        //
    }
}

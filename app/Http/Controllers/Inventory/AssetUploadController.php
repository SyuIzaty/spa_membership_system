<?php

namespace App\Http\Controllers\Inventory;

use Response;
use App\AssetType;
use App\AssetClass;
use App\AssetCustodian;
use App\AssetCodeType;
use App\SpaceRoom;
use App\AssetAcquisition;
use App\AssetAvailability;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AssetUploadController extends Controller
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

    public function asset_bulk_upload (Request $request)
    {
        $code = AssetCodeType::all();

        $type = AssetType::all();

        $class = AssetClass::all();

        $acquisition = AssetAcquisition::all();

        $availability = AssetAvailability::all();

        $custodian = AssetCustodian::all();

        $space = SpaceRoom::all();

        return view('inventory.asset.asset-upload', compact('code','type','acquisition','availability','custodian','class', 'space'));
    }

    public function asset_template()
    {
        $file = storage_path()."/template/ASSET_LISTS.xlsx";

        $headers = array('Content-Type: application/xlsx',);

        return Response::download($file, 'ASSET_LISTS.xlsx',$headers);
    }

    public function import_asset_list(Request $request)
    {
        $this->validate($request, [
            'import_file' => 'required|mimes:csv,xlx,xls,xlsx',
        ]);

        Excel::import(new AssetImport, request()->file('import_file'));

        return back();
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

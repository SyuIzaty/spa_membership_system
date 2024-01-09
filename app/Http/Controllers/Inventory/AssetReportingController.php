<?php

namespace App\Http\Controllers\Inventory;

use Auth;
use App\Asset;
use App\AssetType;
use App\AssetCustodian;
use App\AssetDepartment;
use Illuminate\Http\Request;
use App\Exports\AssetReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AssetReportingController extends Controller
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

    public function asset_report()
    {
        if (Auth::user()->hasPermissionTo('admin management')){

            $department = AssetDepartment::all();

        } else {

            $departmentCustodian = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id')->toArray();

            $department = AssetDepartment::whereIn('id', $departmentCustodian)->get();
        }

        return view('inventory.asset.asset-report', compact('department'));
    }

    public function get_asset(Request $request)
    {
        $departmentCode = $request->input('department_code');

        $assetData = Asset::whereHas('type', function($q) use($departmentCode){
            $q->where('department_id', $departmentCode);
        })->get();

        return response()->json($assetData);
    }

    public function get_type(Request $request)
    {
        $departmentCode = $request->input('department_code');

        $typeData = AssetType::where('department_id', $departmentCode)->get();

        return response()->json($typeData);
    }

    public function get_custodian(Request $request)
    {
        $departmentCode = $request->input('department_code');

        $custodianData = AssetCustodian::where('department_id', $departmentCode)->with(['custodian'])->get();

        return response()->json($custodianData);
    }

    public function data_excel_report(Request $request)
    {
        $department = $request->input('department');

        $asset = (array) $request->input('asset');

        $type = $request->input('type');

        $custodian = $request->input('custodian');

        $query = Asset::query();

        if (empty($department) && empty($asset) && empty($type) && empty($custodian)) {

            $query;

        } elseif (!empty($department) && empty($asset) && empty($type) && empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            });

        } elseif (!empty($department) && !empty($asset) && empty($type) && empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $asset);

        } elseif (!empty($department) && empty($asset) && !empty($type) && empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('asset_type', $type);

        } elseif (!empty($department) && empty($asset) && empty($type) && !empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('custodian_id', $custodian);

        } elseif (!empty($department) && !empty($asset) && !empty($type) && empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $asset)->where('asset_type', $type);

        } elseif (!empty($department) && !empty($asset) && empty($type) && !empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $asset)->where('custodian_id', $custodian);

        } elseif (!empty($department) && empty($asset) && !empty($type) && !empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('asset_type', $type)->where('custodian_id', $custodian);

        } elseif (!empty($department) && !empty($asset) && !empty($type) && !empty($custodian)) {

            $query->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $asset)->where('asset_type', $type)->where('custodian_id', $custodian);

        } else {

            $query = $query->where('id', '<', 0);
        }

        $query = $query->select('inv_assets.*');

        return datatables()::of($query)

            ->editColumn('department_id', function ($query) {

                return $query->type->department->department_name ?? '-';
            })

            ->editColumn('asset_code_type', function ($query) {

                return $query->codeType->code_name ?? '-';
            })

            ->editColumn('asset_type', function ($query) {

                return $query->type->asset_type ?? '-';
            })

            ->editColumn('asset_class', function ($query) {

                return $query->assetClass->class_name ?? '-';
            })

            ->editColumn('custodian_id', function ($query) {

                return $query->custodian->name ?? '-';
            })

            ->editColumn('status', function ($query) {

                $color = ($query->status == '1') ? '#3CBC3C' : '#CC0000';

                $statusText = ($query->status == '1') ? 'ACTIVE' : 'INACTIVE';

                return '<div style="text-transform: uppercase; color:' . $color . '"><b>' . $statusText . '</b></div>';

            })

            ->editColumn('availability', function ($query) {

                return $query->assetAvailability->name ?? '-';
            })

            ->rawColumns(['department_id', 'asset_code_type', 'asset_type', 'asset_class', 'custodian_id', 'status', 'availability'])

            ->make(true);
    }

    public function asset_report_excel($department, $asset, $type, $custodian)
    {
        return Excel::download(new AssetReportExport($department, $asset, $type, $custodian), 'Asset Report Excel.xlsx');
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

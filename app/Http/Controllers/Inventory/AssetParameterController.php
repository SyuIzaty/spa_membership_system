<?php

namespace App\Http\Controllers\Inventory;

use DB;
use Auth;
use Session;
use App\User;
use App\Asset;
use App\AssetType;
use App\AssetClass;
use App\Departments;
use App\AssetCustodian;
use App\AssetDepartment;
use App\InventoryLog;
use App\AssetCodeType;
use App\AssetAcquisition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetParameterController extends Controller
{
    // Asset Type

    public function asset_type()
    {
        $department = AssetDepartment::all();

        return view('inventory.asset-type.index', compact('department'));
    }

    public function data_asset_type()
    {
        $assetType = AssetType::with(['department'])->select('inv_asset_types.*');

        return datatables()::of($assetType)

        ->editColumn('id', function ($assetType) {

            return $assetType->id;
        })

        ->addColumn('action', function ($assetType) {

            $exist = Asset::where('asset_type', $assetType->id)->first();

            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-type="'.$assetType->id.'" data-department="'.$assetType->department_id.'" data-asset="'.$assetType->asset_type.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-type="'.$assetType->id.'" data-department="'.$assetType->department_id.'" data-asset="'.$assetType->asset_type.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-asset-type/' . $assetType->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->editColumn('department_id', function ($assetType) {

            return $assetType->department->department_name ?? 'N/A';
        })

        ->rawColumns(['action', 'id', 'department_id'])
        ->make(true);
    }

    public function store_asset_type(Request $request)
    {
        $request->validate([
            'department_id'   => 'required',
            'asset_type'      => 'required',
        ]);

        $assetType = AssetType::create([
            'department_id'     => $request->department_id,
            'asset_type'        => $request->asset_type,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset Type',
            'subject_id'        => $assetType->id,
            'subject_type'      => 'App\AssetType',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Type Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_type(Request $request)
    {
        $request->validate([
            'department_id'   => 'required',
            'asset_type'      => 'required',
        ]);

        $assetType = AssetType::where('id', $request->type_id)->first();

        $assetType->update([
            'department_id' => $request->department_id,
            'asset_type'    => $request->asset_type,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Type',
            'subject_id'        => $assetType->id,
            'subject_type'      => 'App\AssetType',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Type Updated Succesfuly.');

        return redirect()->back();
    }

    public function delete_asset_type($id)
    {
        $exist = AssetType::find($id);

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Type',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetType',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Asset Type Deleted Successfully.']);
    }

    // Asset Department

    public function asset_department()
    {
        $exist = AssetDepartment::select('department_id')->pluck('department_id')->toArray();

        $department = Departments::whereNotIn('id', $exist)->get();

        return view('inventory.asset-department.index', compact('department'));
    }

    public function data_asset_department()
    {
        $assetDepartment = AssetDepartment::select('inv_asset_departments.*');

        return datatables()::of($assetDepartment)

        ->editColumn('id', function ($assetDepartment) {

            return $assetDepartment->id;
        })

        ->editColumn('department_id', function ($assetDepartment) {

            return $assetDepartment->department->department_name ?? '-';
        })

        ->addColumn('action', function ($assetDepartment) {

            $exist = AssetCustodian::where('department_id', $assetDepartment->id)->first();

            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetDepartment->id.'" data-department="'.$assetDepartment->department_name.'" data-departmentid="'.$assetDepartment->department->department_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetDepartment->id.'" data-department="'.$assetDepartment->department_name.'" data-departmentid="'.$assetDepartment->department->department_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-asset-department/' . $assetDepartment->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->addColumn('manager', function ($assetDepartment) {

            return '<div class="btn-group"><a href="/department-custodian/' . $assetDepartment->id . '" class="btn btn-sm btn-info"><i class="fal fa-cogs"></i></a></div>';
        })

        ->addColumn('total', function ($assetDepartment) {

            $total = AssetCustodian::where('department_id', $assetDepartment->id)->count();

            return '<b>'.$total.'</b>';
        })

        ->rawColumns(['action', 'id', 'total','manager','department_id'])
        ->make(true);
    }

    public function store_asset_department(Request $request)
    {
        $request->validate([
            'department_id'     => 'required',
            'department_name'   => 'required',
        ]);

        $assetDepartment = AssetDepartment::create([
            'department_id'       => $request->department_id,
            'department_name'     => $request->department_name,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset Department',
            'subject_id'        => $assetDepartment->id,
            'subject_type'      => 'App\AssetDepartment',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Department Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_department(Request $request)
    {
        $request->validate([
            'department_names'      => 'required',
        ]);

        $assetDepartment = AssetDepartment::where('id', $request->id)->first();

        $assetDepartment->update([
            'department_name'    => $request->department_names,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Department',
            'subject_id'        => $assetDepartment->id,
            'subject_type'      => 'App\AssetDepartment',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Department Updated Succesfuly.');

        return redirect()->back();
    }

    public function delete_asset_department($id)
    {
        $exist = AssetDepartment::find($id);

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Department',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetDepartment',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Asset Department Deleted Successfully.']);
    }

    // Department Custodian

    public function department_custodian($id)
    {
        $department = AssetDepartment::where('id', $id)->first();

        $existData = AssetCustodian::where('department_id', $id)->first();

        if (isset($existData)) {

            $existCustodian = AssetCustodian::where('department_id', $id)->pluck('custodian_id')->toArray();

            $staff = User::where('active', 'Y')->where('category','STF')
                ->whereNotIn('id', $existCustodian)
                ->get();
        } else {

            $staff = User::where('active', 'Y')->where('category','STF')->get();
        }

        return view('inventory.asset-department.detail', compact('department', 'staff'));
    }

    public function data_department_custodian($id)
    {
        $custodian = AssetCustodian::where('department_id', $id)->with(['custodian'])->select('inv_asset_department_custodians.*');

        return datatables()::of($custodian)

        ->editColumn('id', function ($custodian) {

            return $custodian->id;
        })

        ->addColumn('action', function ($custodian) {

            $exist = Asset::where('custodian_id', $custodian->custodian_id)->first();

            if(isset($exist)) {

                return '<p style="color:red">Exist</p>';

            } else {

                return '<div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-department-custodian/' . $custodian->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->editColumn('custodian_name', function ($custodian) {

             return $custodian->custodian->name ?? 'N/A';
        })

        ->rawColumns(['action', 'id','custodian_name'])
        ->make(true);
    }

    public function store_department_custodian(Request $request)
    {
        foreach($request->input('custodian_id') as $key => $value) {

            $assetCustodian = AssetCustodian::create([
                'department_id'        => $request->id,
                'custodian_id'         => $value,
            ]);

            InventoryLog::create([
                'name'              => 'default',
                'description'       => 'Create Department Custodian',
                'subject_id'        => $assetCustodian->id,
                'subject_type'      => 'App\AssetCustodian',
                'properties'        => json_encode($request->all()),
                'creator_id'        => Auth::user()->id,
                'creator_type'      => 'App\User',
            ]);

            $role = DB::connection('auth')->table('roles')->where('name', 'Asset Manager')->first();

            if ($role) {

                $user = User::find($value);

                $existingRole = DB::connection('auth')->table('model_has_roles')
                    ->where('model_id', $user->id)
                    ->where('model_type', 'App\User')
                    ->where('role_id', $role->id)
                    ->first();

                if (!$existingRole) {

                    DB::connection('auth')->table('model_has_roles')->insert([
                        'model_id' => $user->id,
                        'model_type' => 'App\User',
                        'role_id' => $role->id,
                    ]);
                }
            }

        }

        Session::flash('message', 'Department Custodian Added Successfully.');

        return redirect()->back();
    }

    public function delete_department_custodian($id)
    {
        $exist = AssetCustodian::find($id);

        DB::connection('auth')->table('model_has_roles')
            ->where('model_type', 'App\User')
            ->where('model_id', $exist->custodian_id)
            ->where('role_id', 'INV005')
            ->delete();

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Department Custodian',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetCustodian',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Department Custodian Deleted Successfully.']);
    }

    // Asset Class

    public function asset_class()
    {
        return view('inventory.asset-class.index');
    }

    public function data_asset_class()
    {
        $assetClass = AssetClass::select('inv_asset_classes.*');

        return datatables()::of($assetClass)

        ->addColumn('action', function ($assetClass) {

            $exist = Asset::where('asset_class', $assetClass->id)->first();

            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-code="'.$assetClass->class_code.'" data-name="'.$assetClass->class_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-code="'.$assetClass->class_code.'" data-name="'.$assetClass->class_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-asset-class/' . $assetClass->class_code . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function store_asset_class(Request $request)
    {
        $request->validate([
            'class_code'   => 'required',
            'class_name'   => 'required',
        ]);

        $assetClass = AssetClass::create([
            'class_code'     => strtoupper($request->class_code),
            'class_name'     => strtoupper($request->class_name),
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset Class',
            'subject_id'        => $assetClass->id,
            'subject_type'      => 'App\AssetClass',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Class Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_class(Request $request)
    {
        $request->validate([
            'class_names'   => 'required',
        ]);

        $assetClass = AssetClass::where('class_code', $request->class_id)->first();

        $assetClass->update([
            'class_name'     => strtoupper($request->class_names),
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Class',
            'subject_id'        => $assetClass->id,
            'subject_type'      => 'App\AssetClass',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Class Updated Succesfuly.');

        return redirect()->back();
    }

    public function delete_asset_class($id)
    {
        $exist = AssetClass::find($id);

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Class',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetClass',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Asset Class Deleted Successfully.']);
    }

    // Asset Code Type

    public function asset_code()
    {
        return view('inventory.asset-code.index');
    }

    public function data_asset_code()
    {
        $assetCode = AssetCodeType::select('inv_asset_code_types.*');

        return datatables()::of($assetCode)

        ->addColumn('action', function ($assetCode) {

            $exist = Asset::where('asset_code_type', $assetCode->id)->first();

            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetCode->id.'" data-name="'.$assetCode->code_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetCode->id.'" data-name="'.$assetCode->code_name.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-asset-code/' . $assetCode->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function store_asset_code(Request $request)
    {
        $request->validate([
            'id'          => 'required',
            'code_name'   => 'required',
        ]);

        $assetCode = AssetCodeType::create([
            'id'            => $request->id,
            'code_name'     => $request->code_name,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset Code Type',
            'subject_id'        => $assetCode->id,
            'subject_type'      => 'App\AssetCodeType',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Code Type Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_code(Request $request)
    {
        $request->validate([
            'code_names'   => 'required',
        ]);

        $assetCode = AssetCodeType::where('id', $request->code_id)->first();

        $assetCode->update([
            'code_name'     => $request->code_names,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Code Type',
            'subject_id'        => $assetCode->id,
            'subject_type'      => 'App\AssetCodeType',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Code Type Updated Succesfuly.');

        return redirect()->back();
    }

    public function delete_asset_code($id)
    {
        $exist = AssetCodeType::find($id);

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Code Type',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetCodeType',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Asset Code Type Deleted Successfully.']);
    }

    // Asset Acquisition

    public function asset_acquisition()
    {
        return view('inventory.asset-acquisition.index');
    }

    public function data_asset_acquisition()
    {
        $assetAcquisition = AssetAcquisition::select('inv_asset_acquisitions.*');

        return datatables()::of($assetAcquisition)

        ->addColumn('action', function ($assetAcquisition) {

            $exist = Asset::where('acquisition_type', $assetAcquisition->id)->first();

            if(isset($exist)) {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetAcquisition->id.'" data-acquisition="'.$assetAcquisition->acquisition_type.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a></div>';

            } else {

                return '<div class="btn-group"><a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$assetAcquisition->id.'" data-acquisition="'.$assetAcquisition->acquisition_type.'" class="btn btn-sm btn-warning mr-1"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-asset-acquisition/' . $assetAcquisition->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->rawColumns(['action'])
        ->make(true);
    }

    public function store_asset_acquisition(Request $request)
    {
        $request->validate([
            'acquisition_type'   => 'required',
        ]);

        $assetAcquisition = AssetAcquisition::create([
            'acquisition_type'     => $request->acquisition_type,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset Acquisition',
            'subject_id'        => $assetAcquisition->id,
            'subject_type'      => 'App\AssetAcquisition',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Acquisition Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_acquisition(Request $request)
    {
        $request->validate([
            'acquisition_types'   => 'required',
        ]);

        $assetAcquisition = AssetAcquisition::where('id', $request->acquisition_id)->first();

        $assetAcquisition->update([
            'acquisition_type'     => $request->acquisition_types,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Acquisition',
            'subject_id'        => $assetAcquisition->id,
            'subject_type'      => 'App\AssetAcquisition',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Asset Acquisition Updated Succesfuly.');

        return redirect()->back();
    }

    public function delete_asset_acquisition($id)
    {
        $exist = AssetAcquisition::find($id);

        $exist->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Acquisition',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AssetAcquisition',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success'=>'Asset Acquisition Deleted Successfully.']);
    }

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

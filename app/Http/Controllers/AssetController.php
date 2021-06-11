<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AssetType;
use App\InventoryStatus;
use App\AssetCustodian;
use App\AssetDepartment;
use App\Asset;
use App\Custodian;
use Carbon\Carbon;
use App\AssetImage;
use Session;
use Response;
use Auth;
use File;
use DB;

class AssetController extends Controller
{
    
    public function assetIndex()
    {  
        return view('inventory.asset-index');
    }

    public function assetNew()
    {
        $department = AssetDepartment::all();
        $members = User::whereHas('roles', function($query){
            $query->where('id', 'INV002');
        })->get();
        $status = InventoryStatus::whereIn('id', ['1','2'])->get();

        $asset = new Asset();
        return view('inventory.asset-new', compact('department', 'members', 'asset', 'status'));
    }

    public function findAssetType(Request $request)
    {
        $data = AssetType::select('asset_type', 'id')
                ->where('department_id', $request->id)
                ->take(100)->get();

        return response()->json($data);
    }

    public function findCustodian(Request $request)
    {
        $data = AssetCustodian::select('custodian_id', 'id')
                ->where('department_id', $request->id)
                ->with(['custodian'])
                ->take(100)->get();

        return response()->json($data);
    }

    public function newAssetStore(Request $request)
    {
        $user = Auth::user();
        $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

        $request->validate([
            'department_id'     => 'required',
            'asset_type'        => 'required',
            'asset_name'        => 'required',
            'serial_no'         => 'required',
            'model'             => 'required',
            'purchase_date'     => 'required',
            'vendor_name'       => 'required',
            'custodian_id'      => 'required',
        ]);

        $asset = Asset::create([
            'asset_type'            => $request->asset_type,
            'asset_code'            => $code,
            'asset_name'            => $request->asset_name, 
            'serial_no'             => $request->serial_no, 
            'model'                 => $request->model,
            'brand'                 => $request->brand,
            'status'                => $request->status,
            'purchase_date'         => $request->purchase_date,
            'vendor_name'           => $request->vendor_name,
            'lo_no'                 => $request->lo_no,
            'do_no'                 => $request->do_no,
            'io_no'                 => $request->io_no,
            'total_price'           => $request->total_price,
            'remark'                => $request->remark,
            'storage_location'      => $request->storage_location,
            'custodian_id'          => $request->custodian_id, 
            'created_by'            => $user->id,
            'barcode'               => $code,
            'qrcode'                => $code,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/asset/";

        if (isset($image)) { 
            $originalsName = $image->getClientOriginalName();
            $fileSizes = $image->getSize();
            $fileNames = $originalsName;
            $image->storeAs('/asset', $fileNames);
            AssetImage::create([
                'asset_id'  => $asset->id,
                'upload_image' => $originalsName,
                'web_path'  => "app/asset/".$fileNames,
            ]);
        }

        $asset = Custodian::create([
            'asset_id'         => $asset->id,
            'custodian_id'     => $asset->custodian_id,
            'assigned_by'      => $user->id,
        ]);
            
        Session::flash('message', 'New Asset Data Have Been Successfully Recorded');
        return redirect('/asset-index');
    }

    public function assetDelete($id)
    {
        $exist = Asset::find($id);
        $exist->delete();
        return response()->json(['success'=>'Asset Deleted Successfully']);
    }

    public function data_assetList()
    {
        $asset = Asset::all();

        return datatables()::of($asset)
        ->addColumn('action', function ($asset) {

            return '<a href="/asset-detail/' . $asset->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-index/' . $asset->id . '"><i class="fal fa-trash"></i></button>'; 
        })

        ->addColumn('purchase_date', function ($asset) {

            return date(' d/m/Y ', strtotime($asset->purchase_date)); 
        })

        ->editColumn('asset_name', function ($asset) {

            return isset($asset->asset_name) ? strtoupper($asset->asset_name) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('department_id', function ($asset) {

            return isset($asset->type->department->department_name) ? strtoupper($asset->type->department->department_name) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return isset($asset->custodian->custodian->name) ? $asset->custodian->custodian->name : '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($asset) {

            return isset($asset->type->asset_type) ? strtoupper($asset->type->asset_type) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('status', function ($asset) {

            if($asset->status=='1')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->invStatus->status_name.'</b></div>';
            }
            else 
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->invStatus->status_name.'</b></div>';
            }
        })
        
        ->rawColumns(['action', 'status', 'custodian_id', 'department_id', 'purchase_date', 'asset_type', 'asset_name'])
        ->make(true);
    }

    public function assetDetail($id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->first();
        $department = AssetDepartment::all();
        $status = InventoryStatus::whereIn('id', ['1','2'])->get();

        return view('inventory.asset-detail', compact('asset', 'image', 'department', 'status'))->with('no', 1);
    }

    public function getImage($file)
    {
        $path = storage_path().'/'.'app'.'/asset/'.$file;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function assetUpdate(Request $request)
    {
        $asset = Asset::where('id', $request->id)->first();

        $request->validate([
            'department_id'     => 'required',
            'asset_type'        => 'required',
            'asset_name'        => 'required',
            'serial_no'         => 'required',
            'model'             => 'required',
            'purchase_date'     => 'required',
            'vendor_name'       => 'required',
            'custodian_id'      => 'required',
        ]);

        $asset->update([
            'asset_name'            => $request->asset_name, 
            'serial_no'             => $request->serial_no, 
            'model'                 => $request->model,
            'brand'                 => $request->brand,
            'status'                => $request->status,
            'purchase_date'         => $request->purchase_date,
            'vendor_name'           => $request->vendor_name,
            'lo_no'                 => $request->lo_no,
            'do_no'                 => $request->do_no,
            'io_no'                 => $request->io_no,
            'total_price'           => $request->total_price,
            'remark'                => $request->remark,
            'storage_location'      => $request->storage_location,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/asset/";

        if (isset($image)) { 

            AssetImage::where('asset_id', $request->id)->delete();

            $originalsName = $image->getClientOriginalName();
            $fileSizes = $image->getSize();
            $fileNames = $originalsName;
            $image->storeAs('/asset', $fileNames);
            AssetImage::create([
                'asset_id'  => $asset->id,
                'upload_image' => $originalsName,
                'web_path'  => "app/asset/".$fileNames,
            ]);
        }

        Session::flash('notification', 'Asset Details Successfully Updated');
        return redirect('asset-detail/'.$request->id);
    }

    public function createCustodian(Request $request)
    {
        $user = Auth::user();
        $asset = Asset::where('id', $request->id)->first();

        $request->validate([
            'custodian_id'      => 'required',
            'reason_remark'     => 'nullable',
        ]);

        $custodian = Custodian::create([
            'asset_id'              => $request->id, 
            'custodian_id'          => $request->custodian_id, 
            'reason_remark'         => $request->reason_remark, 
            'assigned_by'           => $user->id,
        ]);

        $asset->update([
            'custodian_id'            => $request->custodian_id, 
        ]);

        Session::flash('msg', 'New Custodian Added Successfully');
        return redirect('asset-detail/'.$request->id);
    }

    public function updateCustodian(Request $request)
    {
        $user = Auth::user();
        $custodian = Custodian::where('id', $request->ids)->first();

        $request->validate([
            'reason_remark'     => 'nullable',
        ]);

        $custodian->update([
            'reason_remark'         => $request->reason_remark, 
        ]);

        Session::flash('noty', 'Custodian Updated Successfully');
        return redirect('asset-detail/'.$request->id);
    }

    public function assetPdf(Request $request, $id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->first();
        return view('inventory.asset-pdf', compact('asset', 'image'));
    }

    public function asset_all(Request $request)
    {
        $department = AssetDepartment::select('id', 'department_name')->orderBy('department_name')->get();
        $status = InventoryStatus::select('id', 'status_name')->get();
        $type = AssetType::select('id', 'asset_type')->get();
        
        $cond = "1"; // 1 = selected

        $selecteddepartment = $request->department; 
        $selectedstatus = $request->status; 
        $selectedtype = $request->type; 
        $list = [];

        return view('inventory.asset-report', compact('request', 'department', 'type', 'status', 'selecteddepartment', 'selectedstatus', 'selectedtype', 'list'));
    }

    public function exports($department = null, $status = null, $type = null)
    {
        return Excel::download(new AssetExport($department, $status, $type), 'Asset.xlsx');
    }

    public function data_assetexport(Request $request) 
    {
        $cond = "1";
        if($request->department && $request->department != "All")
        {
            $cond .= " AND asset_type = '".$request->department."' ";
        }

        if( $request->status != "" && $request->status != "All")
        {
            $cond .= " AND status = '".$request->status."' ";
        }

        if( $request->type != "" && $request->type != "All")
        {
            $cond .= " AND asset_type = '".$request->type."' ";
        }

        $asset = Asset::whereRaw($cond)->get();

        return datatables()::of($asset)

        ->editColumn('asset_name', function ($asset) {

            return strtoupper(isset($asset->asset_name) ? $asset->asset_name : '<div style="color:red;" > -- </div>');
        })

        ->editColumn('asset_code', function ($asset) {

            return isset($asset->asset_code) ? $asset->asset_code : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('asset_type', function ($asset) {

            return isset($asset->type->asset_type) ? $asset->type->asset_type : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('serial_no', function ($asset) {

            return isset($asset->serial_no) ? $asset->serial_no : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('model', function ($asset) {

            return isset($asset->model) ? $asset->model : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('brand', function ($asset) {

            return isset($asset->brand) ? $asset->brand : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('total_price', function ($asset) {

            return isset($asset->total_price) ? $asset->total_price : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('lo_no', function ($asset) {

            return isset($asset->lo_no) ? $asset->lo_no : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('io_no', function ($asset) {

            return isset($asset->io_no) ? $asset->io_no : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('do_no', function ($asset) {

            return isset($asset->do_no) ? $asset->do_no : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('purchase_date', function ($asset) {
           
            return isset($asset->purchase_date) ? date(' d-m-Y ', strtotime($asset->purchase_date) ) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('vendor_name', function ($asset) {

            return isset($asset->vendor_name) ? $asset->vendor_name : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return isset($asset->custodian->custodian->name) ? $asset->custodian->custodian->name : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('created_by', function ($asset) {

            return isset($asset->user->name) ? $asset->user->name : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('remark', function ($asset) {

            return isset($asset->remark) ? $asset->remark : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('status', function ($asset) {

            return isset($asset->invStatus->status_name) ? $asset->invStatus->status_name : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('storage_location', function ($asset) {

            return isset($asset->storage_location) ? $asset->storage_location : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('barcode', function ($asset) {

            return isset($asset->barcode) ? $asset->barcode : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('qrcode', function ($asset) {

            return isset($asset->qrcode) ? $asset->qrcode : '<div style="color:red;" > -- </div>';
        })
    
       ->rawColumns(['asset_code', 'asset_name', 'asset_type', 'serial_no', 'model', 'brand', 'total_price', 'lo_no', 'io_no', 'do_no', 'purchase_date', 'vendor_name', 'custodian_id', 'created_by', 'remark', 'status', 'barcode', 'qrcode', 'storage_location'])
       ->make(true);
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

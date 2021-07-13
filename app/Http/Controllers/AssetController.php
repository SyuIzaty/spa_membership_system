<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AssetType;
use App\AssetAvailability;
use App\AssetCustodian;
use App\AssetDepartment;
use App\Asset;
use App\AssetSet;
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

        $members = User::whereHas('roles', function($query){
            $query->where('id', 'INV002');
        })->get();        
        $custodian = User::all();
        $availability = AssetAvailability::all();
        $asset = new Asset();
        $assetSet = new AssetSet();
        return view('inventory.asset-new', compact('department', 'members', 'asset', 'availability', 'assetSet', 'custodian'));
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
            'status'            => 'required',
            'set_package'       => 'required',
        ]);

        $asset = Asset::create([
            'asset_type'            => $request->asset_type,
            'asset_code'            => $code,
            'finance_code'          => $request->finance_code,
            'asset_name'            => strtoupper($request->asset_name), 
            'serial_no'             => strtoupper($request->serial_no), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
            'availability'          => $request->availability,
            'purchase_date'         => $request->purchase_date,
            'vendor_name'           => $request->vendor_name,
            'lo_no'                 => $request->lo_no,
            'do_no'                 => $request->do_no,
            'io_no'                 => $request->io_no,
            'total_price'           => $request->total_price,
            'remark'                => $request->remark,
            'set_package'           => $request->set_package,
            'storage_location'      => $request->storage_location,
            'custodian_id'          => $request->custodian_id, 
            'created_by'            => $user->id,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/asset/";

        if (isset($image)) { 
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/asset', $fileNames);
                AssetImage::create([
                    'asset_id'  => $asset->id,
                    'upload_image' => $originalsName,
                    'web_path'  => "app/asset/".$fileNames,
                ]);
            }
        }
        
        foreach($request->input('asset_types') as $key => $value) {
            if(isset($value) && !empty($value))
            {
                AssetSet::create([
                    'asset_id'      => $asset->id,
                    'asset_type'    => $value,
                    'serial_no'     => strtoupper($request->serial_nos[$key]),
                    'model'         => strtoupper($request->models[$key]),
                    'brand'         => strtoupper($request->brands[$key]),
                ]);
            }
        }

        $cust = Custodian::create([
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
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $asset = Asset::all();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

            $asset = Asset::whereHas('type',function($q) use ($as){
                $q->whereHas('department', function($q) use ($as){
                    $q->whereIn('id', $as);
                });
            });
        }

        return datatables()::of($asset)
        ->addColumn('action', function ($asset) {

            return '<a href="/asset-detail/' . $asset->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-index/' . $asset->id . '"><i class="fal fa-trash"></i></button>'; 
          
        })

        ->addColumn('purchase_date', function ($asset) {

            return date(' d/m/Y ', strtotime($asset->purchase_date)) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($asset) {

            return strtoupper($asset->asset_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('department_id', function ($asset) {

            return strtoupper($asset->type->department->department_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return $asset->custodians->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($asset) {

            return strtoupper($asset->type->asset_type) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('created_by', function ($asset) {

            return strtoupper($asset->user->name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('status', function ($asset) {

            if($asset->status=='0')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>INACTIVE</b></div>';
            }
            else 
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>ACTIVE</b></div>';
            }
        })

        ->editColumn('availability', function ($asset) {

            if($asset->availability=='1')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->availabilities->name.'</b></div>';
            }
            elseif($asset->availability=='2')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->availabilities->name.'</b></div>';
            }
            else
            {
                return '--';
            }
        })
        
        ->rawColumns(['action', 'status', 'custodian_id', 'department_id', 'purchase_date', 'asset_type', 'asset_name', 'availability', 'created_by'])
        ->make(true);
    }

    public function assetDetail($id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->get();
        $department = AssetDepartment::all();
        $availability = AssetAvailability::all();
        $set = AssetSet::where('asset_id', $id)->get();
        $custodian = User::all();
        $setType = AssetType::where('department_id', $asset->type->department_id)->get();

        return view('inventory.asset-detail', compact('asset', 'image', 'department', 'availability', 'set', 'setType', 'custodian'))->with('no', 1)->with('num', 1);
    }

    public function deleteImage($id, $asset_id)
    {
        $asset = Asset::where('id', $asset_id)->first();
        $image = AssetImage::find($id);
        $image->delete($asset);
        return redirect()->back()->with('messages', 'Asset Image Deleted Successfully');
    }

    public function deleteSet($id, $asset_id)
    {
        $asset = Asset::where('id', $asset_id)->first();
        $set = AssetSet::find($id);
        $set->delete($asset);
        return redirect()->back()->with('messages', 'Asset Set Deleted Successfully');
    }

    public function updateSet(Request $request)
    {
        $set = AssetSet::where('id', $request->ids)->first();

        $set->update([
            'serial_no'     => $request->serial_no, 
            'model'         => $request->model, 
            'brand'         => $request->brand, 
        ]);

        Session::flash('notySet', 'Set Updated Successfully');
        return redirect('asset-detail/'.$set->asset_id);
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
            'asset_name'        => 'required',
            'serial_no'         => 'required',
            'model'             => 'required',
            'set_package'       => 'required',
            'status'            => 'required',
        ]);

        $asset->update([
            'asset_name'            => strtoupper($request->asset_name), 
            'finance_code'          => $request->finance_code, 
            'serial_no'             => strtoupper($request->serial_no), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
            'availability'          => $request->availability,
            'storage_location'      => $request->storage_location,
            'set_package'           => $request->set_package,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/asset/";

        if (isset($image)) { 
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/asset', $fileNames);
                AssetImage::create([
                    'asset_id'  => $asset->id,
                    'upload_image' => $originalsName,
                    'web_path'  => "app/asset/".$fileNames,
                ]);
            }
        }

        foreach($request->input('asset_types') as $key => $value) {
            if(isset($value) && !empty($value))
            {
                AssetSet::create([
                    'asset_id'      => $asset->id,
                    'asset_type'    => $value,
                    'serial_no'     => strtoupper($request->serial_nos[$key]),
                    'model'         => strtoupper($request->models[$key]),
                    'brand'         => strtoupper($request->brands[$key]),
                ]);
            }
        }

        Session::flash('notification', 'Asset Details Successfully Updated');
        return redirect('asset-detail/'.$request->id);
    }

    public function assetPurchaseUpdate(Request $request)
    {
        $asset = Asset::where('id', $request->id)->first();

        $request->validate([
            'purchase_date'     => 'required',
            'vendor_name'       => 'required',
        ]);

        $asset->update([
            'vendor_name'            => $request->vendor_name, 
            'purchase_date'          => $request->purchase_date, 
            'lo_no'                  => $request->lo_no,
            'do_no'                  => $request->do_no,
            'io_no'                  => $request->io_no,
            'total_price'            => $request->total_price,
            'remark'                 => $request->remark,
        ]);

        Session::flash('notifications', 'Asset Details Successfully Updated');
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
        $image = AssetImage::where('asset_id', $id)->get();
        $set = AssetSet::where('asset_id', $id)->get();
         
        return view('inventory.asset-pdf', compact('asset', 'image', 'set'))->with('num', 1);
    }

    public function asset_all(Request $request)
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $department = AssetDepartment::select('id', 'department_name')->orderBy('department_name')->get();
        }
        else
        {
            $department = AssetDepartment::select('id', 'department_name')->orderBy('department_name')->whereHas('custodians', function($query){
                $query->where('custodian_id', Auth::user()->id);
            })->get();
        }

        $availability = AssetAvailability::select('id', 'name')->get();

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $type = AssetType::select('id', 'asset_type')->get();
        }
        else
        {
            $type = AssetType::select('id', 'asset_type')->whereHas('department', function($query){
                $query->whereHas('custodians', function($query){
                    $query->where('custodian_id', Auth::user()->id);
                });
            })->get();
        }

        $cond = "1"; // 1 = selected

        $selecteddepartment = $request->department; 
        $selectedavailability = $request->availability; 
        $selectedtype = $request->type; 
        $selectedstatus = $request->status; 
        $list = [];

        return view('inventory.asset-report', compact('request', 'department', 'type', 'availability', 'selectedstatus', 'selecteddepartment', 'selectedavailability', 'selectedtype', 'list'));
    }

    public function exports($department = null, $availability = null, $type = null, $status = null)
    {
        return Excel::download(new AssetExport($department, $availability, $type, $status), 'Asset.xlsx');
    }

    public function data_assetexport(Request $request) 
    {
        $cond = "1";
        if($request->department && $request->department != "All")
        {
            $cond .= " AND asset_type = '".$request->department."' ";
        }

        if( $request->availability != "" && $request->availability != "All")
        {
            $cond .= " AND availability = '".$request->availability."' ";
        }

        if( $request->type != "" && $request->type != "All")
        {
            $cond .= " AND asset_type = '".$request->type."' ";
        }

        if( $request->status != "" && $request->status != "All")
        {
            $cond .= " AND status = '".$request->status."' ";
        }

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $asset = Asset::whereRaw($cond)->get();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

            $asset = Asset::whereHas('type',function($q) use ($as){
                $q->whereHas('department', function($q) use ($as){
                    $q->whereIn('id', $as);
                });
            })->whereRaw($cond)->get();
        }

        return datatables()::of($asset)

        ->editColumn('asset_name', function ($asset) {

            return $asset->asset_name ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('asset_code', function ($asset) {

            return $asset->asset_code ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('asset_type', function ($asset) {

            return $asset->type->asset_type ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('serial_no', function ($asset) {

            return $asset->serial_no ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('model', function ($asset) {

            return $asset->model ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('brand', function ($asset) {

            return $asset->brand ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('total_price', function ($asset) {

            return $asset->total_price ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('lo_no', function ($asset) {

            return $asset->lo_no ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('io_no', function ($asset) {

            return $asset->io_no ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('do_no', function ($asset) {

            return $asset->do_no ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('purchase_date', function ($asset) {
           
            return date(' d-m-Y ', strtotime($asset->purchase_date) ) ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('vendor_name', function ($asset) {

            return $asset->vendor_name ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return $asset->custodians->name ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('created_by', function ($asset) {

            return $asset->user->name ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('remark', function ($asset) {

            return $asset->remark ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('availability', function ($asset) {

            return isset($asset->availabilities->name) ? strtoupper($asset->availabilities->name) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('status', function ($asset) {

            if($asset->status == '1') {
                return isset($asset->status) ? 'ACTIVE' : '<div style="color:red;" > -- </div>';
            } else {
                return isset($asset->status) ? 'INACTIVE' : '<div style="color:red;" > -- </div>';
            }
        })

        ->editColumn('set_package', function ($asset) {

            if($asset->set_package == 'Y') {
                return isset($asset->set_package) ? 'YES' : '<div style="color:red;" > -- </div>';
            } else {
                return isset($asset->set_package) ? 'NO' : '<div style="color:red;" > -- </div>';
            }
        })

        ->editColumn('storage_location', function ($asset) {

            return $asset->storage_location ?? '<div style="color:red;" > -- </div>';
        })
    
       ->rawColumns(['asset_code', 'asset_name', 'asset_type', 'set_package', 'status', 'serial_no', 'model', 'brand', 'total_price', 'lo_no', 'io_no', 'do_no', 'purchase_date', 'vendor_name', 'custodian_id', 'created_by', 'remark', 'availability', 'storage_location'])
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

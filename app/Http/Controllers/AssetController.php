<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Borrow;
use App\Asset;
use App\AssetImage;
use App\AssetSet;
use App\Custodian;
use App\AssetType;
use App\AssetCodeType;
use App\AssetStatus;
use App\AssetTrail;
use App\AssetAvailability;
use App\AssetCustodian;
use App\AssetDepartment;
use App\CustodianStatus;
use App\AssetAcquisition;
use App\AssetSetTrail;
use App\Exports\IndividualAssetExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Imports\AssetImport;
use Carbon\Carbon;
use Session;
use Response;
use Auth;
use File;
use DB;

class AssetController extends Controller
{
    public function dashboard()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $id = AssetCustodian::groupBy('department_id')->pluck('department_id');
        }
        else
        {
            $id = AssetCustodian::where('custodian_id', Auth::user()->id)->groupBy('department_id')->pluck('department_id');
        }
         
        $assetType = AssetType::orderBy('asset_type')->get();
        $assetStatus = AssetStatus::all();
        $assetAcquisition = AssetAcquisition::all();
         
        return view('inventory.dashboard', compact('id','assetType', 'assetStatus', 'assetAcquisition'));
    }

    // Asset List
    public function assetIndex()
    {  
        $data_department = AssetDepartment::all();
        $data_code = AssetCodeType::all();
        $data_type = AssetType::all();
        $data_status = AssetStatus::all();
        $data_availability = AssetAvailability::all();

        return view('inventory.asset-index', compact('data_department','data_code','data_type','data_status','data_availability'));
    }

    public function assetNew()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $department = AssetDepartment::orderBy('department_name')->get();
        }
        else
        {
            $department = AssetDepartment::whereHas('custodians', function($query){
                $query->where('custodian_id', Auth::user()->id);
            })->orderBy('department_name')->get();
        }

        $members = User::whereHas('roles', function($query){
            $query->where('id', 'INV002');
        })->orderBy('name')->get();        
        $custodian = User::orderBy('name')->get();
        $availability = AssetAvailability::all();
        $codeType = AssetCodeType::all();
        $asset = new Asset();
        $assetSet = new AssetSet();
        $status = AssetStatus::all();
        $acquisition = AssetAcquisition::all();

        return view('inventory.asset-new', compact('department', 'members', 'asset', 'availability', 'assetSet', 'custodian','codeType','status','acquisition'));
    }

    public function findAssetType(Request $request)
    {
        $data = AssetType::select('asset_type', 'id')
                ->orderBy('asset_type')
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

        if($request->status == '0') {
            $request->validate([
                'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                'department_id'     => 'required',
                'asset_type'        => 'required',
                'asset_name'        => 'required',
                'serial_no'         => 'required',
                'custodian_id'      => 'required',
                'status'            => 'required',
                'set_package'       => 'required',
                'asset_code_type'   => 'required',
                'inactive_date'     => 'required',
                'inactive_reason'   => 'required',
            ]);

        } else {
            $request->validate([
                'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                'department_id'     => 'required',
                'asset_type'        => 'required',
                'asset_name'        => 'required',
                'serial_no'         => 'required',
                'custodian_id'      => 'required',
                'status'            => 'required',
                'set_package'       => 'required',
                'asset_code_type'   => 'required',
            ]);
        }
        
        $asset = Asset::create([
            'asset_type'            => $request->asset_type,
            'asset_code'            => $code,
            'asset_code_type'       => $request->asset_code_type,
            'finance_code'          => $request->finance_code,
            'asset_name'            => strtoupper($request->asset_name), 
            'serial_no'             => strtoupper($request->serial_no), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
            'inactive_date'         => $request->inactive_date,
            'inactive_reason'       => $request->inactive_reason,
            'inactive_remark'       => $request->inactive_remark,
            'availability'          => $request->availability,
            'purchase_date'         => $request->purchase_date,
            'vendor_name'           => $request->vendor_name,
            'lo_no'                 => $request->lo_no,
            'do_no'                 => $request->do_no,
            'io_no'                 => $request->io_no,
            'total_price'           => $request->total_price,
            'remark'                => $request->remark,
            'acquisition_type'      => $request->acquisition_type,
            'set_package'           => $request->set_package,
            'storage_location'      => $request->storage_location,
            'custodian_id'          => $request->custodian_id, 
            'created_by'            => $user->id,
        ]);

        $trail = AssetTrail::create([
            'asset_id'              => $asset->id,
            'asset_type'            => $request->asset_type,
            'asset_code'            => $asset->asset_code,
            'asset_code_type'       => $request->asset_code_type,
            'finance_code'          => $request->finance_code,
            'asset_name'            => strtoupper($request->asset_name), 
            'serial_no'             => strtoupper($request->serial_no), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
            'inactive_date'         => $request->inactive_date,
            'inactive_reason'       => $request->inactive_reason,
            'inactive_remark'       => $request->inactive_remark,
            'availability'          => $request->availability,
            'purchase_date'         => $request->purchase_date,
            'vendor_name'           => $request->vendor_name,
            'lo_no'                 => $request->lo_no,
            'do_no'                 => $request->do_no,
            'io_no'                 => $request->io_no,
            'total_price'           => $request->total_price,
            'remark'                => $request->remark,
            'acquisition_type'      => $request->acquisition_type,
            'set_package'           => $request->set_package,
            'storage_location'      => $request->storage_location,
            'custodian_id'          => $request->custodian_id, 
            'created_by'            => $asset->created_by,
            'updated_by'            => $user->id,
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

        foreach($request->input('asset_types') as $key => $value) {
            if(isset($value) && !empty($value))
            {
                AssetSetTrail::create([
                    'asset_trail_id'    => $trail->id,
                    'asset_type'        => $value,
                    'serial_no'         => strtoupper($request->serial_nos[$key]),
                    'model'             => strtoupper($request->models[$key]),
                    'brand'             => strtoupper($request->brands[$key]),
                ]);
            }
        }

        $cust = Custodian::create([
            'asset_id'         => $asset->id,
            'custodian_id'     => $asset->custodian_id,
            'location'         => $asset->storage_location,
            'assigned_by'      => $user->id,
            'verification'     => '0',
            'status'           => '1',
        ]);

        if(isset($cust->staff->staff_email))
        {
            $data = [
                'receiver_name'     => $cust->staff->staff_name,
                'assign_date'       => date(' j F Y ', strtotime( $cust->created_at )),
                'details'           => $asset->asset_code.' : '.$asset->asset_name,
            ];

            Mail::send('inventory.verify-mail', $data, function($message) use ($cust) {
                $message->to($cust->staff->staff_email)->subject('Asset Custodian Verification');
                $message->from(Auth::user()->email);
            });
        }

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

            return '<div class="btn-group"><a href="/asset-detail/' . $asset->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-index/' . $asset->id . '"><i class="fal fa-trash"></i></button></div>'; 
          
        })

        ->addColumn('purchase_date', function ($asset) {

            return isset($asset->purchase_date) ? date(' d/m/Y ', strtotime($asset->purchase_date)) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($asset) {

            return $asset->asset_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('serial_no', function ($asset) {

            return $asset->serial_no ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('model', function ($asset) {

            return $asset->model ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('finance_code', function ($asset) {

            return $asset->finance_code ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('department_id', function ($asset) {

            return $asset->type->department->department_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return $asset->custodians->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($asset) {

            return $asset->type->asset_type ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code_type', function ($asset) {

            return $asset->codeType->code_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('created_by', function ($asset) {

            return $asset->user->name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('status', function ($asset) {

            if($asset->status=='0')
            {
                $color = '#CC0000';
                $reason = $asset->assetStatus->status_name ?? '--';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>INACTIVE</b><br>('.$reason.')</div>';
            }
            elseif($asset->status=='1')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>ACTIVE</b></div>';
            } else {
                return '<div style="color:red;" >--</div>';
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
        
        ->rawColumns(['action', 'status', 'custodian_id', 'department_id', 'purchase_date', 'asset_type', 'asset_name', 'availability', 'created_by', 'asset_code_type', 'finance_code', 'model', 'serial_no'])
        ->make(true);
    }

    public function assetDetail($id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->get();
        $department = AssetDepartment::all();
        $availability = AssetAvailability::all();
        $set = AssetSet::where('asset_id', $id)->get();
        $custodian = User::orderBy('name')->get();
        $setType = AssetType::where('department_id', $asset->type->department_id)->get();
        $codeType = AssetCodeType::all();
        $status = AssetStatus::all();
        $acquisition = AssetAcquisition::all();
        $assetTrail = AssetTrail::where('asset_id', $id)->orderBy('created_at', 'desc')->get();
        $borrow = Borrow::where('asset_id', $id)->whereNull('actual_return_date')->where('status','1')->first();

        return view('inventory.asset-detail', compact('borrow', 'asset', 'image', 'department', 'availability', 'set', 'setType', 'custodian', 'codeType', 'status', 'assetTrail', 'acquisition'))->with('no', 1)->with('num', 1);
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
        $assets = Asset::where('id', $request->id)->first();
        
        if($request->status != $asset->status) {
        // request status != asset status
            if($request->status == '0') {
            // check between 1 or 0
                if($asset->status == '1') {
                // check former status 1 or not
                    $request->validate([
                        'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                        'asset_name'        => 'required',
                        'serial_no'         => 'required',
                        'set_package'       => 'required',
                        'status'            => 'required',
                        'inactive_date'     => 'required',
                        'inactive_reason'   => 'required',
                        'asset_code_type'   => 'required',
                    ]);
        
                    $asset->update([
                        'asset_name'            => strtoupper($request->asset_name), 
                        'finance_code'          => $request->finance_code, 
                        'serial_no'             => strtoupper($request->serial_no), 
                        'model'                 => strtoupper($request->model),
                        'brand'                 => strtoupper($request->brand),
                        'status'                => $request->status,
                        'availability'          => $request->availability,
                        'set_package'           => $request->set_package,
                        'asset_code_type'       => $request->asset_code_type,
                        'inactive_date'         => $request->inactive_date,
                        'inactive_reason'       => $request->inactive_reason,
                        'inactive_remark'       => $request->inactive_remark,
                    ]);

                } else {
                  // former status 0
                    $request->validate([
                        'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                        'asset_name'        => 'required',
                        'serial_no'         => 'required',
                        'set_package'       => 'required',
                        'status'            => 'required',
                        'asset_code_type'   => 'required',
                    ]);
        
                    $asset->update([
                        'asset_name'            => strtoupper($request->asset_name), 
                        'finance_code'          => $request->finance_code, 
                        'serial_no'             => strtoupper($request->serial_no), 
                        'model'                 => strtoupper($request->model),
                        'brand'                 => strtoupper($request->brand),
                        'status'                => $request->status,
                        'availability'          => $request->availability,
                        'set_package'           => $request->set_package,
                        'asset_code_type'       => $request->asset_code_type,
                        'inactive_date'         => null,
                        'inactive_reason'       => null,
                        'inactive_remark'       => null,
                    ]);
                }
            } else {
              // request status == 1
                $request->validate([
                    'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                    'asset_name'        => 'required',
                    'serial_no'         => 'required',
                    'set_package'       => 'required',
                    'status'            => 'required',
                    'asset_code_type'   => 'required',
                ]);
    
                $asset->update([
                    'asset_name'            => strtoupper($request->asset_name), 
                    'finance_code'          => $request->finance_code, 
                    'serial_no'             => strtoupper($request->serial_no), 
                    'model'                 => strtoupper($request->model),
                    'brand'                 => strtoupper($request->brand),
                    'status'                => $request->status,
                    'availability'          => $request->availability,
                    'set_package'           => $request->set_package,
                    'asset_code_type'       => $request->asset_code_type,
                    'inactive_date'         => null,
                    'inactive_reason'       => null,
                    'inactive_remark'       => null,
                ]);

            }      
        } else {
          // request status == asset status
             if($request->status == '0') {
              // request status == 0
                $request->validate([
                    'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                    'asset_name'        => 'required',
                    'serial_no'         => 'required',
                    'set_package'       => 'required',
                    'status'            => 'required',
                    'asset_code_type'   => 'required',
                    'inactive_date'     => 'required',
                    'inactive_reason'   => 'required',
                    'asset_code_type'   => 'required',
                ]);
    
                $asset->update([
                    'asset_name'            => strtoupper($request->asset_name), 
                    'finance_code'          => $request->finance_code, 
                    'serial_no'             => strtoupper($request->serial_no), 
                    'model'                 => strtoupper($request->model),
                    'brand'                 => strtoupper($request->brand),
                    'status'                => $request->status,
                    'availability'          => $request->availability,
                    'set_package'           => $request->set_package,
                    'asset_code_type'       => $request->asset_code_type,
                    'inactive_date'         => $request->inactive_date,
                    'inactive_reason'       => $request->inactive_reason,
                    'inactive_remark'       => $request->inactive_remark,
                ]);

             } else {
                // request status == 1
                $request->validate([
                    'finance_code'      => 'nullable|unique:inv_asset,finance_code,' .$request->id,
                    'asset_name'        => 'required',
                    'serial_no'         => 'required',
                    'set_package'       => 'required',
                    'status'            => 'required',
                    'asset_code_type'   => 'required',
                ]);
    
                $asset->update([
                    'asset_name'            => strtoupper($request->asset_name), 
                    'finance_code'          => $request->finance_code, 
                    'serial_no'             => strtoupper($request->serial_no), 
                    'model'                 => strtoupper($request->model),
                    'brand'                 => strtoupper($request->brand),
                    'status'                => $request->status,
                    'availability'          => $request->availability,
                    'set_package'           => $request->set_package,
                    'asset_code_type'       => $request->asset_code_type,
                ]);

             }
        }

        if($request->asset_name != $assets->asset_name || $request->asset_code_type != $assets->asset_code_type || $request->serial_no != $assets->serial_no || $request->status != $assets->status)
        {
           $trail = AssetTrail::create([
                'asset_id'              => $asset->id,
                'asset_type'            => $asset->asset_type,
                'asset_code'            => $asset->asset_code,
                'asset_code_type'       => $asset->asset_code_type,
                'finance_code'          => $asset->finance_code,
                'asset_name'            => strtoupper($asset->asset_name), 
                'serial_no'             => strtoupper($asset->serial_no), 
                'model'                 => strtoupper($asset->model),
                'brand'                 => strtoupper($asset->brand),
                'status'                => $asset->status,
                'inactive_date'         => $asset->inactive_date,
                'inactive_reason'       => $asset->inactive_reason,
                'inactive_remark'       => $asset->inactive_remark,
                'availability'          => $asset->availability,
                'purchase_date'         => $asset->purchase_date,
                'vendor_name'           => $asset->vendor_name,
                'lo_no'                 => $asset->lo_no,
                'do_no'                 => $asset->do_no,
                'io_no'                 => $asset->io_no,
                'total_price'           => $asset->total_price,
                'remark'                => $asset->remark,
                'acquisition_type'      => $asset->acquisition_type,
                'set_package'           => $asset->set_package,
                'storage_location'      => $asset->storage_location,
                'custodian_id'          => $asset->custodian_id, 
                'created_by'            => $asset->created_by,
                'updated_by'            => Auth::user()->id,
            ]);
        }

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

        foreach($request->input('asset_types') as $key => $value) {
            if(isset($value) && !empty($value))
            {
                AssetSetTrail::create([
                    'asset_id'      => $trail->id,
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
        $assets = Asset::where('id', $request->id)->first();

        $asset->update([
            'vendor_name'            => $request->vendor_name, 
            'purchase_date'          => $request->purchase_date, 
            'lo_no'                  => $request->lo_no,
            'do_no'                  => $request->do_no,
            'io_no'                  => $request->io_no,
            'total_price'            => $request->total_price,
            'remark'                 => $request->remark,
            'acquisition_type'       => $request->acquisition_type,
        ]);

        if($request->vendor_name != $assets->vendor_name || $request->purchase_date != $assets->purchase_date || $request->lo_no != $assets->lo_no || 
            $request->do_no != $assets->do_no || $request->io_no != $assets->io_no || $request->total_price != $assets->total_price || 
            $request->remark != $assets->remark || $request->acquisition_type != $assets->acquisition_type)
        {
           AssetTrail::create([
                'asset_id'              => $asset->id,
                'asset_type'            => $asset->asset_type,
                'asset_code'            => $asset->asset_code,
                'asset_code_type'       => $asset->asset_code_type,
                'finance_code'          => $asset->finance_code,
                'asset_name'            => strtoupper($asset->asset_name), 
                'serial_no'             => strtoupper($asset->serial_no), 
                'model'                 => strtoupper($asset->model),
                'brand'                 => strtoupper($asset->brand),
                'status'                => $asset->status,
                'inactive_date'         => $asset->inactive_date,
                'inactive_reason'       => $asset->inactive_reason,
                'inactive_remark'       => $asset->inactive_remark,
                'availability'          => $asset->availability,
                'purchase_date'         => $asset->purchase_date,
                'vendor_name'           => $asset->vendor_name,
                'lo_no'                 => $asset->lo_no,
                'do_no'                 => $asset->do_no,
                'io_no'                 => $asset->io_no,
                'total_price'           => $asset->total_price,
                'remark'                => $asset->remark,
                'acquisition_type'      => $asset->acquisition_type,
                'set_package'           => $asset->set_package,
                'storage_location'      => $asset->storage_location,
                'custodian_id'          => $asset->custodian_id, 
                'created_by'            => $asset->created_by,
                'updated_by'            => Auth::user()->id,
            ]);
        }

        Session::flash('notifications', 'Asset Details Successfully Updated');
        return redirect('asset-detail/'.$request->id);
    }

    public function createCustodian(Request $request)
    {
        $user = Auth::user();
        $asset = Asset::where('id', $request->id)->first();
        $latestCustodian = Custodian::where('asset_id', $request->id)->latest('created_at')->first();

        $request->validate([
            'custodian_id'      => 'required',
            'reason_remark'     => 'nullable',
        ]);

        $latestCustodian->update([
            'status'                => '3',
        ]);

        $custodian = Custodian::create([
            'asset_id'              => $request->id, 
            'custodian_id'          => $request->custodian_id, 
            'reason_remark'         => $request->reason_remark, 
            'location'              => $request->location, 
            'assigned_by'           => $user->id,
            'verification'          => '0',
            'status'                => '1',
        ]);

        $asset->update([
            'custodian_id'            => $request->custodian_id, 
            'storage_location'        => $request->location, 
        ]);

        if(isset($custodian->staff->staff_email))
        {
            $data = [
                'receiver_name'     => $custodian->staff->staff_name,
                'assign_date'       => date(' j F Y ', strtotime( $custodian->created_at )),
                'details'           => $asset->asset_code.' : '.$asset->asset_name,
            ];

            Mail::send('inventory.verify-mail', $data, function($message) use ($custodian) {
                $message->to($custodian->staff->staff_email)->subject('Asset Custodian Verification');
                $message->from(Auth::user()->email);
            });
        }

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
            'location'              => $request->location, 
        ]);

        Session::flash('noty', 'Custodian Updated Successfully');
        return redirect('asset-detail/'.$request->id);
    }

    public function assetPdf(Request $request, $id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->get();
        $set = AssetSet::where('asset_id', $id)->get();
        $borrow = Borrow::where('asset_id', $id)->whereNull('actual_return_date')->where('status','1')->first();
         
        return view('inventory.asset-pdf', compact('asset', 'image', 'set', 'borrow'))->with('num', 1);
    }

    public function trailPdf(Request $request, $id)
    {
        $asset = Asset::where('id', $id)->first();
         
        return view('inventory.trail-pdf', compact('asset'));
    }

    public function custodianPdf(Request $request, $id)
    {
        $asset = Asset::where('id', $id)->first();
         
        return view('inventory.custodian-pdf', compact('asset'));
    }

    public function assetTrail($id)
    {
        $asset = AssetTrail::where('id', $id)->first(); 
        $set = AssetSetTrail::where('asset_trail_id', $id)->get();

        return view('inventory.asset-trail', compact('asset', 'set'))->with('num', 1);
    }

    // My Asset 
    public function verifyList()
    {  
        $data_department = AssetDepartment::all();
        $data_code = AssetCodeType::all();
        $data_type = AssetType::all();

        return view('inventory.verify-list', compact('data_department','data_code','data_type'));
    }

    public function data_verifyList()
    {
        $verify = Custodian::where('custodian_id', Auth::user()->id)->where('verification', '0')->where('status', '1')->get();

        return datatables()::of($verify)
        
        ->addColumn('stylesheet', function ($pendingClaim) {
            return [
                [
                    'col' => 7,
                    'style' => [
                        'background' => '#FF0000',
                        'color' => '#fff',
                    ],
                ],
            ];
        })

        ->addColumn('verification', function ($verify) {

            return ' <button class="btn btn-sm btn-danger btn-verify" data-remote="/verification/' . $verify->asset_id . '"><i class="fal fa-pencil"></i></button>'; 
        })

        ->addColumn('action', function ($verify) {

            return '<div class="btn-group"><a href="/asset-info/' . $verify->asset_id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a></div>'; 
        })

        ->editColumn('id', function ($verify) {
            
            return $verify->assets->id ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code_type', function ($verify) {
             
            return $verify->assets->codeType->code_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('assigned_date', function ($verify) {
             
            return date(' Y-m-d ', strtotime($verify->created_at)) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($verify) {

            $name       = $verify->assets->asset_name ?? '--';
            $serial     = $verify->assets->serial_no ?? '--';
            $model      = $verify->assets->model ?? '--';
            $storage    = $verify->assets->storage_location ?? '--';
            $code       = $verify->assets->asset_code ?? '--';
            $finance    = $verify->assets->finance_code ?? '--';

            return '<div style="line-height:25px"><b>ASSET CODE</b> : '.$code.'<br><b>FINANCE CODE</b> : '.$finance.'<br><b>NAME</b> : '.$name.'<br><b>SERIAL NO.</b> : '.$serial.'<br><b>MODEL</b> : '.$model.'<br><b>LOCATION</b> : '.$storage.'</div>' ?? '--';
        })

        ->editColumn('department', function ($verify) {

            return $verify->assets->type->department->department_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('assigned_by', function ($verify) {

            return $verify->user->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($verify) {

            return $verify->assets->type->asset_type ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('delay', function ($verify) {

            $delay = Carbon::parse($verify->created_at)->diffInDays(Carbon::now())+1;

            if($delay != 1){
                return $delay . ' DAYS';
            } else {
                return $delay . ' DAY';
            }
          
            return $delay;
        })
        
        ->rawColumns(['action', 'delay', 'asset_type', 'assigned_by', 'department', 'asset_name', 'assigned_date', 'asset_code_type', 'id', 'verification'])
        ->make(true);
    }

    public function updateVerification($id)
    {
        Custodian::where('asset_id', $id)->where('custodian_id', Auth::user()->id)->update([
            'verification'      => '1',
            'status'            => '2',
            'verification_date' => Carbon::now(),
        ]);

        return response()->json(['success'=>'Verification Successfull']);
    }

    public function individualList()
    {  
        $data_department = AssetDepartment::all();
        $data_code = AssetCodeType::all();
        $data_type = AssetType::all();

        return view('inventory.individual-list', compact('data_department','data_code','data_type'));
    }

    public function data_individualList()
    {
        $verify = Custodian::where('custodian_id', Auth::user()->id)->where('verification', '1')->where('status', '2')->get();

        return datatables()::of($verify)

        ->addColumn('action', function ($verify) {

            return '<div class="btn-group"><a href="/asset-info/' . $verify->asset_id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a></div>'; 
        })

        ->editColumn('id', function ($verify) {
            
            return $verify->assets->id ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code_type', function ($verify) {
             
            return $verify->assets->codeType->code_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('assigned_date', function ($verify) {
             
            return date(' Y-m-d ', strtotime($verify->created_at)) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('verification_date', function ($verify) {
             
            return date(' Y-m-d ', strtotime($verify->verification_date)) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($verify) {

            $name       = $verify->assets->asset_name ?? '--';
            $serial     = $verify->assets->serial_no ?? '--';
            $model      = $verify->assets->model ?? '--';
            $storage    = $verify->assets->storage_location ?? '--';
            $code       = $verify->assets->asset_code ?? '--';
            $finance    = $verify->assets->finance_code ?? '--';

            return '<div style="line-height:25px"><b>ASSET CODE</b> : '.$code.'<br><b>FINANCE CODE</b> : '.$finance.'<br><b>NAME</b> : '.$name.'<br><b>SERIAL NO.</b> : '.$serial.'<br><b>MODEL</b> : '.$model.'<br><b>STORAGE</b> : '.$storage.'</div>' ?? '--';
        })

        ->editColumn('department', function ($verify) {

            return $verify->assets->type->department->department_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('assigned_by', function ($verify) {

            return $verify->user->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($verify) {

            return $verify->assets->type->asset_type ?? '<div style="color:red;" >--</div>';
        })

        ->rawColumns(['action', 'verification_date', 'asset_type', 'assigned_by', 'department', 'asset_name', 'assigned_date', 'asset_code_type', 'id', 'verification'])
        ->make(true);
    }

    public function exportIndividualAsset()
    {
        return Excel::download(new IndividualAssetExport,'MyAsset.xlsx');
    }

    public function assetInfo($id)
    {
        $asset = Asset::where('id', $id)->first(); 
        $image = AssetImage::where('asset_id', $id)->get();
        $set = AssetSet::where('asset_id', $id)->get();
        $borrow = Borrow::where('asset_id', $id)->whereNull('actual_return_date')->where('status','1')->first();

        return view('inventory.asset-info', compact('asset', 'image', 'set', 'borrow'))->with('num', 1);
    }

    // Export
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

        ->editColumn('finance_code', function ($asset) {

            return $asset->finance_code ?? '<div style="color:red;" > -- </div>';
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
           
            return isset($asset->purchase_date) ? date(' d-m-Y ', strtotime($asset->purchase_date)) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('inactive_date', function ($asset) {
           
            return isset($asset->inactive_date) ? date(' d-m-Y ', strtotime($asset->inactive_date)) : '<div style="color:red;" > -- </div>';
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

            if($asset->status == '0') {
                return 'INACTIVE';
            } else {
                return 'ACTIVE';
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

        ->editColumn('department', function ($asset) {

            return strtoupper($asset->type->department->department_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code_type', function ($asset) {

            return strtoupper($asset->codeType->code_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('inactive_reason', function ($asset) {

            return $asset->assetStatus->status_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('inactive_remark', function ($asset) {

            return $asset->inactive_remark ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('acquisition_type', function ($asset) {

            return $asset->acquisitionType->acquisition_type ?? '<div style="color:red;" >--</div>';
        })
    
       ->rawColumns(['inactive_date','finance_code','department', 'asset_code_type', 'asset_code', 'asset_name', 'asset_type', 'set_package', 'status', 'serial_no',
        'model', 'brand', 'total_price', 'lo_no', 'io_no', 'do_no', 'purchase_date', 'vendor_name', 'custodian_id', 'created_by', 'remark', 'availability', 'storage_location',
        'inactive_remark', 'inactive_reason', 'acquisition_type'])
       ->make(true);
    }

    // Search
    public function assetSearch(Request $request)
    {  
        $data = $data2 = $data3 =  '';

        if($request->asset_code)
        {
            $result = new Asset();

            if($request->asset_code != "")
            {
                $result = $result->where('asset_code', $request->asset_code)->orWhere('finance_code', $request->asset_code);
            }
            
            $data = $result->first();
        }
             
        return view('inventory.asset-search', compact('data','request'))->with('num', 1);
    }

    // Upload
    public function bulkUpload(Request $request)
    {
        $code = AssetCodeType::all();
        $acquisition = AssetAcquisition::all();
        $availability = AssetAvailability::all();
        $custodian = User::orderBy('name')->get();
        $data_department = AssetDepartment::all();

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $type = AssetType::all();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

            $type = AssetType::whereHas('department', function($query) use ($as){
                    $query->whereIn('id', $as)->get();
            });
        }

        return view('inventory.asset-upload', compact('code','type','acquisition','availability','custodian','data_department'));
    }

    public function assetTemplate()
    {
        $file = storage_path()."/template/ASSET_LISTS.xlsx";
        $headers = array('Content-Type: application/xlsx',);
        return Response::download($file, 'ASSET_LISTS.xlsx',$headers);
    }

    public function importAsset(Request $request) 
    {
        $this->validate($request, [
            'import_file' => 'required',
        ]);

        Excel::import(new AssetImport, request()->file('import_file'));

        return back();
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

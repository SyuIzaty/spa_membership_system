<?php

namespace App\Http\Controllers\Inventory;

use Auth;
use File;
use Session;
use Response;
use App\User;
use App\Asset;
use App\InventoryLog;
use App\AssetImage;
use App\AssetSet;
use App\Custodian;
use App\AssetType;
use Carbon\Carbon;
use App\AssetCodeType;
use App\AssetStatus;
use App\AssetTrail;
use App\AssetClass;
use App\AssetSetTrail;
use App\AssetAvailability;
use App\AssetCustodian;
use App\AssetDepartment;
use App\AssetAcquisition;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetManagementController extends Controller
{
    public function asset_list()
    {
        $department = AssetDepartment::all();

        $code_type = AssetCodeType::all();

        $type = AssetType::all();

        $availability = AssetAvailability::all();

        $class = AssetClass::all();

        return view('inventory.asset.asset-index', compact('department','code_type','type','availability','class'));
    }

    public function asset_form()
    {
        $data = [
            'department' => AssetDepartment::all(),

            'availability' => AssetAvailability::all(),

            'codeType' => AssetCodeType::all(),

            'asset' => new Asset(),

            'assetSet' => new AssetSet(),

            'status' => AssetStatus::all(),

            'acquisition' => AssetAcquisition::all(),

            'class' => AssetClass::all(),
        ];

        return view('inventory.asset.asset-new', $data);
    }

    public function find_asset_type(Request $request)
    {
        $data = AssetType::select('asset_type', 'id')

                ->orderBy('asset_type')

                ->where('department_id', $request->id)

                ->take(100)->get();

        return response()->json($data);
    }

    public function find_custodian(Request $request)
    {
        $data = AssetCustodian::select('custodian_id', 'id')

                ->where('department_id', $request->id)

                ->with(['custodian'])

                ->take(100)->get();

        return response()->json($data);
    }

    public function store_asset_detail(Request $request)
    {
        $user = Auth::user();
        $code = Carbon::now()->format('Y') . mt_rand(100000, 999999);

        $validationRules = [
            'finance_code'      => 'nullable|unique:inv_assets,finance_code,' . $request->id,
            'department_id'     => 'required',
            'asset_type'        => 'required',
            'asset_name'        => 'required',
            'serial_no'         => 'required',
            'custodian_id'      => 'required',
            'status'            => 'required',
            'set_package'       => 'required',
            'asset_code_type'   => 'required',
            'inactive_date'     => $request->status == '0' ? 'required' : '',
            'inactive_reason'   => $request->status == '0' ? 'required' : '',
            'asset_class'       => 'required',
        ];

        $request->validate($validationRules);

        $asset = Asset::create([
            'asset_type'            => $request->asset_type,
            'asset_class'           => $request->asset_class,
            'asset_code'            => $code,
            'asset_code_type'       => $request->asset_code_type,
            'finance_code'          => $request->finance_code,
            'asset_name'            => $request->asset_name,
            'serial_no'             => $request->serial_no,
            'model'                 => $request->model,
            'brand'                 => $request->brand,
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

        $trail = AssetTrail::create(array_merge([
            'asset_id'    => $asset->id,
            'updated_by'  => $user->id,
            'asset_code'  => $asset->asset_code,
            'created_by'  => $user->id,
        ], $request->all()));

        $images = $request->upload_image ?? [];

        foreach ($images as $file) {
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $storedFileName = date('dmyhi') . ' - ' . $originalName;

            $file->storeAs('/asset/', $storedFileName);

            $assetImg = AssetImage::create([
                'asset_id' => $asset->id,
                'img_name' => $storedFileName,
                'img_size' => $fileSize,
                'img_path' => "asset/" . $storedFileName,
            ]);

            Storage::disk('minio')->put($assetImg->img_path, file_get_contents($file));
        }

        Custodian::create([
            'asset_id'         => $asset->id,
            'custodian_id'     => $asset->custodian_id,
            'location'         => $asset->storage_location,
            'assigned_by'      => $user->id,
            'verification'     => '1',
            'verification_date'=> Carbon::now(),
            'status'           => '2',
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Create Asset',
            'subject_id'        => $asset->id,
            'subject_type'      => 'App\Asset',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'New Asset Have Been Successfully Added.');

        return redirect()->back();
    }

    public function delete_asset_list($id)
    {
        $asset = Asset::find($id);

        if (!$asset) {
            return response()->json(['error' => 'Asset not found'], 404);
        }

        AssetTrail::where('asset_id', $asset->id)->delete();

        $setList = AssetSet::where('asset_id', $asset->id)->get();

        foreach ($setList as $sets) {
            AssetSet::where('asset_set_id', $sets->id)->delete();
        }

        $set = AssetSet::where('asset_id', $asset->id)->get();

        $asset->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset',
            'subject_id'        => $asset->id,
            'subject_type'      => 'App\Asset',
            'properties'        => json_encode($asset),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['success' => 'Asset and related records deleted successfully']);
    }

    public function print_barcode(Request $request)
    {
        $checked = explode(',',$request->mem_checkbox_submit);
        $customPaper = array('0','0','132.28','188.98');
        // cm height: 3.4cm (128.50) 3.5(132.28) + width 5cm

        $pdf = PDF::loadView('inventory.asset.asset-barcode', compact('checked'))->setPaper($customPaper, 'landscape');
        return $pdf->stream('Barcode.pdf');
    }

    public function assetFilter($filter,Request $request)
    {
        $check = $request->checked ? explode(',',$request->checked) : [];

        foreach($request->only('department_id','asset_code_type','finance_code','asset_code','asset_name','asset_type','asset_class','custodian_id','status','availability') as $key => $val){

            if($key == "asset_code_type" && $val){
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->codeType->code_name,$val) !== false ){
                        return $item;
                    }
                });
            } else if($key == "asset_type" && $val) {
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->type->asset_type,$val) !== false ){
                        return $item;
                    }
                });
            } else if($key == "asset_class" && $val) {
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->assetClass->class_code,$val) !== false ){
                        return $item;
                    }
                });
            }else if($key == "custodian_id" && $val) {
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->custodian->name,$val) !== false ){
                        return $item;
                    }
                });
            }
            else if($key == "availability" && $val) {
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->assetAvailability->name,$val) !== false ){
                        return $item;
                    }
                });
            }else if($key == "department_id" && $val) {
                $filter = $filter->filter(function($item) use ($val){
                    if( stripos($item->type->department->department_name,$val) !== false ){
                        return $item;
                    }
                });
            }else if($val) {
                $filter = $filter->filter(function($item) use ($val,$key){
                    if( stripos($item->{$key},$val) !== false ){
                        return $item;
                    }
                });
            }

        }
        $filtered = collect($filter)->pluck('id')->toArray();

        if($request->checkall){

            $check =  array_unique(array_merge($check,$filtered));

        }else if($request->uncheck){

            foreach($filtered as $fil){

                $index = array_search($fil,$check);

                unset($check[$index]);
            }
        }

        $check = implode(',',$check);

        return $check;
    }

    public function data_asset_list(Request $request)
    {
        if (Auth::user()->hasPermissionTo('admin management'))
        {
            $asset = Asset::all();
        }
        else
        {
            $asset = Asset::where('custodian_id', Auth::user()->id)->get();
        }

        $check = $this->assetFilter($asset,$request);

        return datatables()::of($asset)

        ->addColumn('checkone', function ($asset) use ($check) {
            return '<input type="hidden" name="mem_checkbox_submit" class="mem_checkbox_submit" value="'.$check.'">
            <input type="checkbox" name="mem_checkbox[]" value="'.$asset->id.'" class="mem_checkbox">';
        })

        ->addColumn('action', function ($asset) {

            if (Auth::user()->hasPermissionTo('manager management')){
                return '<div class="btn-group"><a href="/asset-detail/' . $asset->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/asset-detail/' . $asset->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/asset-list/' . $asset->id . '"><i class="fal fa-trash"></i></button></div>';
            }

        })

        ->editColumn('asset_name', function ($asset) {

            return $asset->asset_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('finance_code', function ($asset) {

            return $asset->finance_code ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('department_id', function ($asset) {

            return $asset->type->department->department_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('custodian_id', function ($asset) {

            return $asset->custodian->name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_type', function ($asset) {

            return $asset->type->asset_type ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_class', function ($asset) {

            return $asset->assetClass->class_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code_type', function ($asset) {

            return $asset->codeType->code_name ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('status', function ($asset) {

            if($asset->status=='0')
            {
                $color = '#CC0000';
                $reason = $asset->assetStatus->status_name ?? '--';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>INACTIVE</b></div>';
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
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->assetAvailability->name.'</b></div>';
            }
            elseif($asset->availability=='2')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$asset->assetAvailability->name.'</b></div>';
            }
            else
            {
                return '--';
            }
        })

        ->rawColumns(['checked','checkone','action', 'status', 'custodian_id', 'department_id', 'purchase_date', 'asset_type',
        'asset_name', 'availability', 'asset_code_type', 'finance_code','asset_class'])
        ->make(true);
    }

    public function asset_detail($id)
    {
        $asset = Asset::where('id', $id)->first();

        $department = AssetDepartment::all();

        $availability = AssetAvailability::all();

        $custodian = AssetCustodian::select('custodian_id', 'id')->where('department_id', $asset->type->department_id)->get();

        $setType = AssetType::where('department_id', $asset->type->department_id)->get();

        $codeType = AssetCodeType::all();

        $status = AssetStatus::all();

        $acquisition = AssetAcquisition::all();

        $class = AssetClass::all();

        return view('inventory.asset.asset-detail', compact('class', 'asset', 'department', 'availability',
        'setType', 'custodian', 'codeType', 'status', 'acquisition'));
    }

    public function delete_asset_image($id)
    {
        $image = AssetImage::find($id);

        if(Storage::disk('minio')->exists($image->img_path) == 'true'){
            Storage::disk('minio')->delete($image->img_path);
        }

        $image->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Image',
            'subject_id'        => $image->id,
            'subject_type'      => 'App\AssetImage',
            'properties'        => json_encode($image),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        $message = 'Image Have Been Successfully Deleted';

        return response()->json(['message-img' => $message]);
    }

    public function upload_asset_image(Request $request)
    {
        $request->validate([
            'upload_image'     => 'required|array',
            'upload_image.*'   => 'mimes:jpg,jpeg,png',
        ]);

        $files = $request->file('upload_image');

        if (isset($files) && count($files) > 0) {
            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileName = $originalName;

                $storedFileName = date('dmyhi') . ' - ' . $fileName;
                $file->storeAs('/asset', $storedFileName);

                $assetImg = AssetImage::create([
                    'asset_id' => $request->asset_id,
                    'img_name' => $storedFileName,
                    'img_size' => $fileSize,
                    'img_path' => "asset/" . $storedFileName,
                ]);

                InventoryLog::create([
                    'name'              => 'default',
                    'description'       => 'Upload Asset Image',
                    'subject_id'        => $assetImg->id,
                    'subject_type'      => 'App\AssetImage',
                    'properties'        => json_encode($request->all()),
                    'creator_id'        => Auth::user()->id,
                    'creator_type'      => 'App\User',
                ]);

                Storage::disk('minio')->put($assetImg->img_path, file_get_contents($file));
            }
        }

        Session::flash('message-img', 'Image Added Successfully.');

        return redirect()->back();
    }

    public function get_asset_image($filename)
    {
        return Storage::disk('minio')->response('asset/' . $filename);
    }

    public function delete_asset_set($id)
    {
        $set = AssetSet::find($id);

        AssetSetTrail::where('asset_set_id', $set->id)->delete();

        $set->delete();

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Delete Asset Set',
            'subject_id'        => $set->id,
            'subject_type'      => 'App\AssetSet',
            'properties'        => json_encode($set),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        $message = 'Set Have Been Successfully Deleted';

        return response()->json(['message-set' => $message]);
    }

    public function store_asset_set(Request $request)
    {
        $request->validate([
            'asset_types'  => 'required',
            'serial_nos'   => 'required',
        ]);

        $asset = Asset::where('id', $request->asset_id)->first();

        foreach ($request->input('asset_types') as $key => $value) {
            if (!empty($value)) {
                $set = AssetSet::create([
                    'asset_id'      => $asset->id,
                    'asset_type'    => $value,
                    'serial_no'     => $request->serial_nos[$key],
                    'model'         => $request->models[$key],
                    'brand'         => $request->brands[$key],
                ]);

                AssetSetTrail::create([
                    'asset_set_id'    => $set->id,
                    'asset_type'        => $set->asset_type,
                    'serial_no'         => $set->serial_no,
                    'model'             => $set->model,
                    'brand'             => $set->brand,
                    'updated_by'        => Auth::user()->id,
                ]);

                InventoryLog::create([
                    'name'              => 'default',
                    'description'       => 'Create Asset Set',
                    'subject_id'        => $set->id,
                    'subject_type'      => 'App\AssetSet',
                    'properties'        => json_encode($request->all()),
                    'creator_id'        => Auth::user()->id,
                    'creator_type'      => 'App\User',
                ]);
            }
        }

        Session::flash('message-set', 'Set Added Successfully.');

        return redirect()->back();
    }

    public function update_asset_set(Request $request)
    {
        $request->validate([
            'serial_no'   => 'required',
        ]);

        $set = AssetSet::where('id', $request->ids)->first();

        $set->update([
            'serial_no'     => $request->serial_no,
            'model'         => $request->model,
            'brand'         => $request->brand,
        ]);

        AssetSetTrail::create([
            'asset_set_id'      => $set->id,
            'asset_type'        => $set->asset_type,
            'serial_no'         => $set->serial_no,
            'model'             => $set->model,
            'brand'             => $set->brand,
            'updated_by'        => Auth::user()->id,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Set',
            'subject_id'        => $set->id,
            'subject_type'      => 'App\AssetSet',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message-set', 'Set Updated Successfully.');

        return redirect()->back();
    }

    public function update_asset_detail(Request $request)
    {
        $asset = Asset::where('id', $request->id)->first();

        $request->validate([
            'asset_code'        => 'required|unique:inv_assets,asset_code,' .$request->id,
            'finance_code'      => 'nullable|unique:inv_assets,finance_code,' .$request->id,
            'asset_name'        => 'required',
            'serial_no'         => 'required',
            'set_package'       => 'required',
            'status'            => 'required',
            'asset_code_type'   => 'required',
            'asset_class'       => 'required',
        ]);

        $updateData = [
            'asset_name'            => $request->asset_name,
            'asset_code'            => $request->asset_code,
            'finance_code'          => $request->finance_code,
            'serial_no'             => $request->serial_no,
            'model'                 => $request->model,
            'brand'                 => $request->brand,
            'status'                => $request->status,
            'availability'          => $request->availability,
            'set_package'           => $request->set_package,
            'asset_code_type'       => $request->asset_code_type,
            'asset_class'           => $request->asset_class,
            'storage_location'      => $request->storage_location,
            'inactive_date'         => $request->status == '0' ? $request->inactive_date : null,
            'inactive_reason'       => $request->status == '0' ? $request->inactive_reason : null,
            'inactive_remark'       => $request->status == '0' ? $request->inactive_remark : null,
        ];

        $asset->update($updateData);

        if ($request->status == $asset->status) {
            $trailData = $asset->toArray();
            unset($trailData['id']);
            unset($trailData['updated_at']);
            $trailData['updated_by'] = Auth::user()->id;

            AssetTrail::create($trailData);
        }

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Detail',
            'subject_id'        => $asset->id,
            'subject_type'      => 'App\Asset',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);


        Session::flash('message', 'Asset Detail Updated Successfully.');

        return redirect()->back();
    }

    public function update_asset_purchase(Request $request)
    {
        $asset = Asset::find($request->id);

        $updatedFields = [
            'vendor_name', 'purchase_date', 'lo_no', 'do_no', 'io_no',
            'total_price', 'remark', 'acquisition_type'
        ];

        $asset->update($request->only($updatedFields));

        if ($asset->wasChanged($updatedFields)) {
            AssetTrail::create([
                'asset_id'              => $asset->id,
                'asset_type'            => $asset->asset_type,
                'asset_code'            => $asset->asset_code,
                'asset_code_type'       => $asset->asset_code_type,
                'finance_code'          => $asset->finance_code,
                'asset_name'            => $asset->asset_name,
                'serial_no'             => $asset->serial_no,
                'model'                 => $asset->model,
                'brand'                 => $asset->brand,
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

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Purchase Detail',
            'subject_id'        => $asset->id,
            'subject_type'      => 'App\Asset',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message-purchase', 'Purchase Detail Successfully Updated.');

        return redirect()->back();
    }

    public function store_custodian(Request $request)
    {
        $request->validate([
            'custodian_id'      => 'required',
            'reason_remark'     => 'required',
        ]);

        $asset = Asset::where('id', $request->id)->first();

        $latestCustodian = Custodian::where('asset_id', $asset->id)->latest('created_at')->first();

        $latestCustodian->update([
            'status'                => '3',
        ]);

        $custodian = Custodian::create([
            'asset_id'              => $request->id,
            'custodian_id'          => $request->custodian_id,
            'reason_remark'         => $request->reason_remark,
            'location'              => $request->location,
            'assigned_by'           => Auth::user()->id,
            'verification'          => '1',
            'verification_date'     => Carbon::now(),
            'status'                => '2',
        ]);

        $asset->update([
            'custodian_id'            => $request->custodian_id,
            'storage_location'        => $request->location,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Assign Asset Custodian',
            'subject_id'        => $custodian->id,
            'subject_type'      => 'App\Custodian',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message-custodian', 'New Custodian Added Successfully.');

        return redirect()->back();
    }

    public function update_custodian(Request $request)
    {
        $custodian = Custodian::where('id', $request->ids)->first();

        $request->validate([
            'reason_remark'     => 'nullable',
        ]);

        $custodian->update([
            'reason_remark'         => $request->reason_remark,
            'location'              => $request->location,
        ]);

        InventoryLog::create([
            'name'              => 'default',
            'description'       => 'Update Asset Custodian',
            'subject_id'        => $custodian->id,
            'subject_type'      => 'App\Custodian',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message-custodian', 'Custodian Updated Successfully.');

        return redirect()->back();
    }

    public function asset_detail_pdf(Request $request, $id)
    {
        $asset = Asset::where('id', $id)->first();

        return view('inventory.asset.asset-pdf', compact('asset'));
    }

    public function asset_trail_detail($id)
    {
        $asset = AssetTrail::where('id', $id)->first();

        return view('inventory.asset.asset-trail', compact('asset'));
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

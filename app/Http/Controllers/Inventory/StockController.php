<?php

namespace App\Http\Controllers\Inventory;

use DB;
use Auth;
use File;
use App\Staff;
use App\User;
use Session;
use Response;
use App\Stock;
use App\StockImage;
use App\StockTransaction;
use App\Departments;
use Carbon\Carbon;
use App\Exports\StockExport;
use App\Exports\StockReportExport;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
    public function stockIndex()
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $department = Departments::all();

        $role = User::whereHas('roles', function($query) {
            $query->where('name', 'Stock Admin');
        })->get();

        $curr_owner = Stock::select('current_owner')->groupBy('current_owner')->pluck('current_owner')->toArray();

        return view('inventory.stock.stock-index', compact('staff','department','role', 'curr_owner'));
    }

    public function stockTemplate()
    {
        $file = storage_path()."/template/STOCK_LISTS.xls";

        $headers = array('Content-Type: application/xls',);

        return Response::download($file, 'STOCK_LISTS.xls',$headers);
    }

    public function bulkStockStore(Request $request)
    {
        $this->validate($request, [
            'import_file' => 'required|mimes:csv,xlx,xls,xlsx',
        ]);

        Excel::import(new StockImport, request()->file('import_file'));

        return redirect()->back();
    }

    public function newStockStore(Request $request)
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

        $request->validate([
            'stock_name'        => 'required',
            'model'             => 'required',
            'status'            => 'required',
        ]);

        $stock = Stock::create([
            'department_id'             => $staff->staff_code,
            'stock_code'                => $code,
            'stock_name'                => strtoupper($request->stock_name),
            'model'                     => strtoupper($request->model),
            'brand'                     => strtoupper($request->brand),
            'status'                    => $request->status,
            'applicable_for_stationary' => $request->has('applicable_for_stationary') ? 1 : 0,
            'applicable_for_aduan'      => $request->has('applicable_for_aduan') ? 1 : 0,
            'created_by'                => $staff->staff_id,
            'updated_by'                => $staff->staff_id,
            'current_owner'             => $staff->staff_id,
        ]);

        $files = $request->file('upload_image');

        if (isset($files) && count($files) > 0) {
            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $fileName = $originalName;

                $storedFileName = date('dmyhi') . ' - ' . $fileName;
                $file->storeAs('/app/einventory/', $storedFileName);

                $stockImg = StockImage::create([
                    'stock_id' => $stock->id,
                    'img_name' => $storedFileName,
                    'img_size' => $fileSize,
                    'img_path' => "app/einventory/" . $storedFileName,
                ]);

                Storage::disk('minio')->put($stockImg->img_path, file_get_contents($file));
            }
        }

        Session::flash('message', 'New Stock Data Have Been Successfully Recorded');

        return redirect()->back();
    }

    public function uploadImages(Request $request)
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
                $file->storeAs('/app/einventory', $storedFileName);

                $stockImg = StockImage::create([
                    'stock_id' => $request->stock_id,
                    'img_name' => $storedFileName,
                    'img_size' => $fileSize,
                    'img_path' => "app/einventory/" . $storedFileName,
                ]);

                Storage::disk('minio')->put($stockImg->img_path, file_get_contents($file));
            }
        }

        Session::flash('message', 'New Image Data Have Been Successfully Recorded');

        return redirect()->back();
    }

    public function changeOwner(Request $request)
    {
        $request->validate([
            'current_owner'         => 'required',
        ]);

        Stock::where('id', $request->owner_id)->update([
            'current_owner'         => $request->current_owner,
            'updated_by'            => Auth::user()->id,
        ]);

        Session::flash('message', 'Stock have been change its ownership. The current owner can view the stock in their display.');

        return redirect()->back();
    }

    public function changeAccess(Request $request)
    {
        $request->validate([
            'access_owner'         => 'required',
        ]);

        Stock::where('current_owner', $request->user_id)->update([
            'current_owner'         => $request->access_owner,
            'current_co_owner'      => $request->access_co_owner,
            'updated_by'            => Auth::user()->id,
        ]);

        Session::flash('message', 'Stock ownership have been changed successfully.');

        return redirect()->back();
    }

    public function getStockAccess($userId)
    {
        // $stock = Stock::where('current_owner', $userId)->first();

        $stock = Stock::where('current_owner', $userId)
              ->orWhere('current_co_owner', $userId)
              ->first();


        $currentOwnerId = $stock ? $stock->current_owner : null;
        $currentCoOwnerId = $stock ? $stock->current_co_owner : null;

        return response()->json([
            'currentOwnerId' => $currentOwnerId,
            'currentCoOwnerId' => $currentCoOwnerId,
        ]);
    }

    public function data_stockList()
    {
        if (Auth::user()->can('view stock')) {

            $stock = Stock::with(['user','departments'])->get();

        } else {

            $stock = Stock::where(function($query) {
                $query->where('current_owner', Auth::user()->id)
                      ->orWhere('current_co_owner', Auth::user()->id);
            })
            ->with(['user', 'departments'])
            ->get();
        }

        return datatables()::of($stock)

        ->addColumn('action', function ($stock) {

            $exist = StockTransaction::where('stock_id', $stock->id)->first();

            if(isset($exist) || Auth::user()->can('view stock')){
                return '<div class="btn-group"><a href="/stock-detail/' . $stock->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/stock-detail/' . $stock->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/stock-index/' . $stock->id . '"><i class="fal fa-trash"></i></button></div>';
            }
        })

        ->editColumn('id', function ($stock) {

            return '#'.$stock->id;
        })

        ->addColumn('created_at', function ($stock) {

            return date(' d/m/Y ', strtotime($stock->created_at)) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('stock_name', function ($stock) {

            return strtoupper($stock->stock_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('current_owner', function ($stock) {

            // if(Auth::user()->can('view stock')){
            //     return strtoupper($stock->user->name).'<a href="" data-target="#crud-modal-owner" class="ml-2" data-toggle="modal" data-id="'. $stock->id.'">
            //     <i class="fal fa-pencil" style="color: red"></i></a>';
            // } else {
                return strtoupper($stock->user->name) ?? '<div style="color:red;" >--</div>';
            // }

        })

        ->editColumn('status', function ($stock) {

            if($stock->status=='1')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>ACTIVE</b></div>';
            }
            else
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>INACTIVE</b></div>';
            }
        })

        ->addColumn('department_id', function ($stock) {

            return strtoupper($stock->departments->department_name) ?? '<div style="color:red;" >--</div>';
        })

        ->addColumn('current_balance', function ($stock) {

            $total_bal = 0;
            foreach($stock->transaction as $list){
                $total_bal += ($list->stock_in - $list->stock_out);
            }

            return strtoupper($total_bal) ?? '<div style="color:red;" >--</div>';
        })

        ->addColumn('balance_status', function ($stock) {

            $total_bal = 0;
            foreach($stock->transaction as $list){
                $total_bal += ($list->stock_in - $list->stock_out);
            }

            if($total_bal <= 0) {
                $stat = '<b style="color:red">OUT OF STOCK</b>';
            } else {
                $stat = '<b style="color:green">READY STOCK</b>';
            }

            return strtoupper($stat) ?? '<div style="color:red;" >--</div>';
        })

        ->rawColumns(['action', 'status', 'current_owner', 'stock_name', 'created_at', 'current_balance', 'balance_status','department_id'])
        ->make(true);
    }

    public function stockDelete($id)
    {
        $exist = Stock::findOrFail($id);

        StockTransaction::where('stock_id', $exist->id)->delete();

        $images = StockImage::where('stock_id', $exist->id)->get();

        foreach ($images as $image) {

            if (Storage::disk('minio')->exists($image->img_path)) {
                Storage::disk('minio')->delete($image->img_path);
            }
        }

        StockImage::where('stock_id', $exist->id)->delete();

        $exist->update(['deleted_by' => Auth::user()->id]);

        $exist->delete();

        return response()->json(['success' => 'Stock Deleted Successfully']);
    }

    public function stockDetail($id)
    {
        $stock = Stock::where('id', $id)->first();

        $image = StockImage::where('stock_id', $id)->get();

        $user = User::where('category', 'STF')->where('active', 'Y')->get();

        $total_bal = 0;
        foreach($stock->transaction as $list){
            $total_bal += ($list->stock_in - $list->stock_out);
        }

        return view('inventory.stock.stock-detail', compact('stock', 'image', 'total_bal','user'));
    }

    public function deleteImages($id)
    {
        $image = StockImage::find($id);

        if(Storage::disk('minio')->exists($image->img_path) == 'true'){
            Storage::disk('minio')->delete($image->img_path);
        }

        $image->delete();

        $message = 'Stock Image Have Been Successfully Deleted';

        return response()->json(['message' => $message]);
    }

    public function stockUpdate(Request $request)
    {
        $stock = Stock::where('id', $request->id)->first();

        $request->validate([
            'stock_name'        => 'required',
            'model'             => 'required',
            'status'            => 'required',
        ]);

        $stock->update([
            'stock_name'                => strtoupper($request->stock_name),
            'model'                     => strtoupper($request->model),
            'brand'                     => strtoupper($request->brand),
            'status'                    => $request->status,
            'applicable_for_stationary' => $request->has('applicable_for_stationary') ? 1 : 0,
            'applicable_for_aduan'      => $request->has('applicable_for_aduan') ? 1 : 0,
            'updated_by'                => Auth::user()->id,
        ]);

        Session::flash('message', 'Stock Detail Have Been Successfully Updated');

        return redirect()->back();
    }

    public function getImages($filename)
    {
        return Storage::disk('minio')->response('app/einventory/' . $filename);
    }

    public function createTransIn(Request $request)
    {
        $user = Auth::user();

        $balance = $request->stock_in - $request->stock_out;

            $request->validate([
                'stock_in'        => 'required',
                'trans_date'      => 'required',
            ]);

            $stockIn = StockTransaction::create([
                'stock_id'         => $request->id,
                'lo_no'            => $request->lo_no,
                'io_no'            => $request->io_no,
                'purchase_date'    => $request->purchase_date,
                'trans_date'       => $request->trans_date,
                'stock_in'         => $request->stock_in,
                'stock_out'        => $request->stock_in - $balance,
                'unit_price'       => $request->unit_price,
                'created_by'       => $user->id,
                'remark'           => $request->remark,
                'status'           => '1',
            ]);

        Session::flash('message', 'Transaction In Detail Have Been Successfully Recorded');

        return redirect()->back();
    }

    public function createTransOut(Request $request)
    {
        $user = Auth::user();

        $stock = Stock::where('id', $request->id)->first();

        $total_bal = 0;
        foreach($stock->transaction as $list){
            $total_bal += ($list->stock_in - $list->stock_out);
        }

        if($request->supply_type == 'INT') {

            $request->validate([
                'stock_out'        => 'required|numeric|lte:'.$total_bal,
                'reason'           => 'required',
                'trans_date'       => 'required',
                'supply_to'        => 'required',
                'supply_type'      => 'required',
            ]);

            $stockOut = StockTransaction::create([
                'stock_id'         => $request->id,
                'stock_in'         => '0',
                'stock_out'        => $request->stock_out,
                'created_by'       => $user->id,
                'reason'           => $request->reason,
                'supply_type'      => $request->supply_type,
                'supply_to'        => $request->supply_to,
                'trans_date'       => $request->trans_date,
                'status'           => '0',
            ]);
        }

        if($request->supply_type == 'EXT') {

            $request->validate([
                'stock_out'        => 'required|numeric|lte:'.$total_bal,
                'reason'           => 'required',
                'trans_date'       => 'required',
                'supply_type'      => 'required',
                'ext_supply_to'    => 'required',
            ]);

            $stockOut = StockTransaction::create([
                'stock_id'         => $request->id,
                'stock_in'         => '0',
                'stock_out'        => $request->stock_out,
                'created_by'       => $user->id,
                'reason'           => $request->reason,
                'supply_type'      => $request->supply_type,
                'ext_supply_to'    => $request->ext_supply_to,
                'trans_date'       => $request->trans_date,
                'status'           => '0',
            ]);
        }

        Session::flash('message', 'Transaction Out Detail Have Been Successfully Recorded');

        return redirect()->back();
    }

    public function updateTransin(Request $request)
    {
        $user = Auth::user();

        $stock = StockTransaction::where('id', $request->ids)->first();

        $request->validate([
            'stock_in'        => 'required',
            'trans_date'      => 'required',
        ]);

        $stock->update([
                'lo_no'            => $request->lo_no,
                'io_no'            => $request->io_no,
                'purchase_date'    => $request->purchase_date,
                'trans_date'       => $request->trans_date,
                'stock_in'         => $request->stock_in,
                'stock_out'        => '0',
                'unit_price'       => $request->unit_price,
                'remark'           => $request->remark,
        ]);

        Session::flash('message', 'Transaction In Detail Have Been Successfully Updated');

        return redirect()->back();
    }

    public function updateTransout(Request $request)
    {
        $user = Auth::user();

        $stock = StockTransaction::where('id', $request->ids)->first();

        if($stock->supply_type == 'INT') {

            $request->validate([
                'stock_out'        => 'required',
                'reason'           => 'required',
                'trans_date'       => 'required',
                'supply'           => 'required',
            ]);

            $stock->update([
                'stock_in'         => '0',
                'stock_out'        => $request->stock_out,
                'reason'           => $request->reason,
                'supply_to'        => $request->supply,
                'trans_date'       => $request->trans_date,
            ]);
        }

        if($stock->supply_type == 'EXT') {

            $request->validate([
                'stock_out'        => 'required',
                'reason'           => 'required',
                'trans_date'       => 'required',
                'extsupply'        => 'required',
            ]);

            $stock->update([
                'stock_in'         => '0',
                'stock_out'        => $request->stock_out,
                'reason'           => $request->reason,
                'ext_supply_to'    => $request->extsupply,
                'trans_date'       => $request->trans_date,
            ]);
        }

        Session::flash('message', 'Transaction Out Detail Have Been Successfully Updated');

        return redirect()->back();
    }

    public function deleteTrans($id)
    {
        $trans = StockTransaction::find($id);

        $trans->delete();

        $message = 'Transaction Have Been Successfully Deleted';

        return response()->json(['message' => $message]);
    }

    public function stockReport()
    {
        if (Auth::user()->can('view stock')) {

            $department = Departments::all();

        } else {

            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            $department = Departments::where('department_code', $staff->staff_code)->get();
        }

        return view('inventory.stock.stock-report', compact('department'));
    }

    public function getStockByDepartment(Request $request)
    {
        $departmentCode = $request->input('department_code');

        $stockData = Stock::where('department_id', $departmentCode)->get();

        return response()->json($stockData);
    }

    public function getOwnerByDepartment(Request $request)
    {
        $departmentCode = $request->input('department_code');

        $role = User::whereHas('roles', function($query) {
            $query->where('name', 'Stock Admin');
        })->pluck('id')->toArray();

        $ownerData = Staff::whereIn('staff_id', $role)->where('staff_code', $departmentCode)->get();

        return response()->json($ownerData);
    }

    public function dataStockReport(Request $request)
    {
        $department = $request->input('department');

        $stock = (array) $request->input('stock');

        $owner = $request->input('owner');

        $query = Stock::query();

        if (!empty($department) && empty($stock) && empty($owner)) {

            $query->where('department_id', $department);

        } elseif (!empty($department) && !empty($stock) && empty($owner)) {

            $query->where('department_id', $department)->whereIn('id', $stock);

        } elseif (!empty($department) && empty($stock) && !empty($owner)) {

            // $query->where('department_id', $department)->where('current_owner', $owner);
            $query->where('department_id', $department)
                ->where(function($q) use ($owner) {
                    $q->where('current_owner', $owner)
                        ->orWhere('current_co_owner', $owner);
                });

        } elseif (!empty($department) && !empty($stock) && !empty($owner)) {

            // $query->where('department_id', $department)->whereIn('id', $stock)->where('current_owner', $owner);
            $query->where('department_id', $department)
                ->whereIn('id', $stock)
                ->where(function($q) use ($owner) {
                    $q->where('current_owner', $owner)
                        ->orWhere('current_co_owner', $owner);
                });

        } else {

            $query = $query->where('id', '<', 0);
        }

        $query = $query->select('inv_stocks.*');

        return datatables()::of($query)

            ->editColumn('id', function ($query) {

                return '#'.$query->id;
            })

            ->addColumn('created_at', function ($query) {

                return date('d/m/Y', strtotime($query->created_at)) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('stock_name', function ($query) {

                return strtoupper($query->stock_name) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('status', function ($query) {

                $color = ($query->status == '1') ? '#3CBC3C' : '#CC0000';

                $statusText = ($query->status == '1') ? 'ACTIVE' : 'INACTIVE';

                return '<div style="text-transform: uppercase; color:' . $color . '"><b>' . $statusText . '</b></div>';

            })

            ->editColumn('department_id', function ($query) {

                return strtoupper(optional($query->departments)->department_name) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('current_owner', function ($query) {

                if(isset($query->current_co_owner)) {
                    $owner = strtoupper($query->user->name).'<br>'.strtoupper($query->coOwner->name);
                } else {
                    $owner = strtoupper($query->user->name);
                }

                return $owner;

            })

            ->rawColumns(['status', 'stock_name', 'created_at', 'department_id', 'current_owner'])

            ->make(true);
    }

    public function stockReportExcel($department, $stock, $owner)
    {
        return Excel::download(new StockReportExport($department, $stock, $owner), 'Stock Report Excel.xlsx');
    }

    public function exportStock()
    {
        return Excel::download(new StockExport,'Stock Excel.xlsx');
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

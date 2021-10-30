<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockImage;
use App\InventoryStatus;
use App\StockTransaction;
use App\AssetDepartment;
use Carbon\Carbon;
use App\AssetCustodian;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;
use Session;
use Response;
use Auth;
use File;
use DB;
use App\User;

class StockController extends Controller
{
    public function stockIndex()
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

        return view('inventory.stock.stock-index', compact('department'));
    }

    public function newStockStore(Request $request)
    {
        $user = Auth::user();
        $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

        $request->validate([
            'department_id'     => 'required',
            'stock_name'        => 'required',
            'model'             => 'required',
            'status'            => 'required',
        ]);

        $stock = Stock::create([
            'department_id'         => $request->department_id, 
            'stock_code'            => $code,
            'stock_name'            => strtoupper($request->stock_name), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
            'created_by'            => $user->id,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/stock/";

        if (isset($image)) { 
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/stock', $fileNames);
                StockImage::create([
                    'stock_id'  => $stock->id,
                    'upload_image' => $originalsName,
                    'web_path'  => "app/stock/".$fileNames,
                ]);
            }
        }

        Session::flash('message', 'New Stock Data Have Been Successfully Recorded');
        return redirect('/stock-index');
    }

    public function data_stockList()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $stock = Stock::all();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');
            
            $stock = Stock::whereHas('departments', function($q) use ($as){
                    $q->whereIn('id', $as);
                 })->get();
        }

        return datatables()::of($stock)
        ->addColumn('action', function ($stock) {

            return '<div class="btn-group"><a href="/stock-detail/' . $stock->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/stock-index/' . $stock->id . '"><i class="fal fa-trash"></i></button></div>'; 
        })

        ->addColumn('created_at', function ($stock) {

            return date(' d/m/Y ', strtotime($stock->created_at)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('stock_name', function ($stock) {

            return strtoupper($stock->stock_name) ?? '<div style="color:red;" >--</div>';
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

        ->rawColumns(['action', 'status', 'created_by', 'stock_name', 'created_at', 'department_id', 'current_balance', 'balance_status'])
        ->make(true);
    }

    public function stockDelete($id)
    {
        $exist = Stock::find($id);
        $exist->delete();
        return response()->json(['success'=>'Stock Deleted Successfully']);
    }

    public function stockDetail($id)
    {
        $stock = Stock::where('id', $id)->first(); 
        $image = StockImage::where('stock_id', $id)->get();
        $transaction = StockTransaction::where('stock_id', $id)->first();
        $department = AssetDepartment::all();
        $user = User::orderBy('name')->get();

        $total_bal = 0;
        foreach($stock->transaction as $list){
            $total_bal += ($list->stock_in - $list->stock_out);
        }

        return view('inventory.stock.stock-detail', compact('stock', 'image', 'department', 'transaction', 'user', 'total_bal'))->with('no', 1);
    }

    public function deleteImages($id, $stock_id)
    {
        $stock = Stock::where('id', $stock_id)->first();
        $image = StockImage::find($id);
        $image->delete($stock);
        return redirect()->back()->with('messages', 'Stock Image Deleted Successfully');
    }

    public function stockUpdate(Request $request)
    {
        $stock = Stock::where('id', $request->id)->first();

        $request->validate([
            'stock_name'        => 'required',
            'model'             => 'required',
        ]);

        $stock->update([
            'stock_name'            => strtoupper($request->stock_name), 
            'model'                 => strtoupper($request->model),
            'brand'                 => strtoupper($request->brand),
            'status'                => $request->status,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/stock/";

        if (isset($image)) { 

            StockImage::where('stock_id', $request->id)->delete();

            $originalsName = $image->getClientOriginalName();
            $fileSizes = $image->getSize();
            $fileNames = $originalsName;
            $image->storeAs('/stock', $fileNames);
            StockImage::create([
                'stock_id'  => $stock->id,
                'upload_image' => $originalsName,
                'web_path'  => "app/stock/".$fileNames,
            ]);
        }

        Session::flash('notification', 'Stock Details Successfully Updated');
        return redirect('stock-detail/'.$request->id);
    }

    public function getImages($file)
    {
        $path = storage_path().'/'.'app'.'/stock/'.$file;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function createTransIn(Request $request)
    {
        $user = Auth::user();
        $balance = $request->stock_in - $request->stock_out;

            $request->validate([
                'lo_no'           => 'required',
                'io_no'           => 'required',
                'stock_in'        => 'required',
                'unit_price'      => 'required',
                'purchase_date'   => 'required',
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
        
        Session::flash('msg', 'Transaction In Details Successfully Updated');
        return redirect('stock-detail/'.$request->id);
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

        Session::flash('noty', 'Transaction Out Details Successfully Updated');
        return redirect('stock-detail/'.$request->id);
    }

    public function updateTransin(Request $request)
    {
        $user = Auth::user();
        $stock = StockTransaction::where('id', $request->ids)->first();

        $request->validate([
            'lo_no'           => 'required',
            'io_no'           => 'required',
            'stock_in'        => 'required',
            'unit_price'      => 'required',
            'purchase_date'   => 'required',
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

        Session::flash('notyIn', 'Stock Transaction Successfully Updated');
        return redirect('stock-detail/'.$stock->stock_id);
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

        Session::flash('notyOut', 'Stock Transaction Successfully Updated');
        return redirect('stock-detail/'.$stock->stock_id);
    }

    public function deleteTrans($id, $stock_id)
    {
        $stock = Stock::where('id', $stock_id)->first();
        $trans = StockTransaction::find($id);
        $trans->delete($stock);
        return redirect()->back()->with('messages', 'Stock Transaction Deleted Successfully');
    }

    public function stockPdf(Request $request, $id)
    {
        $stock = Stock::where('id', $id)->first(); 
        $image = StockImage::where('stock_id', $id)->first();
        $total_bal = 0;
        foreach($stock->transaction as $list){
            $total_bal += ($list->stock_in - $list->stock_out);
        }
        return view('inventory.stock.stock-pdf', compact('stock', 'image', 'total_bal'))->with('no', 1);
    }

    public function exportStock()
    {
        return Excel::download(new StockExport,'Stock.xlsx');
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

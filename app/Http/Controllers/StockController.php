<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\StockImage;
use App\InventoryStatus;
use App\StockTransaction;
use Carbon\Carbon;
use Session;
use Response;
use Auth;
use File;
use DB;

class StockController extends Controller
{
    public function stockIndex()
    {  
        $status = InventoryStatus::whereIn('id', ['3','4'])->get();

        return view('inventory.stock-index', compact('status'));
    }

    public function newStockStore(Request $request)
    {
        $user = Auth::user();
        $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

        $request->validate([
            'stock_name'        => 'required',
            'model'             => 'required',
        ]);

        $stock = Stock::create([
            'stock_code'            => $code,
            'stock_name'            => $request->stock_name, 
            'model'                 => $request->model,
            'brand'                 => $request->brand,
            'status'                => $request->status,
            'created_by'            => $user->id,
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/stock/";

        if (isset($image)) { 
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

        Session::flash('message', 'New Stock Data Have Been Successfully Recorded');
        return redirect('/stock-index');
    }

    public function data_stockList()
    {
        $stock = Stock::all();

        return datatables()::of($stock)
        ->addColumn('action', function ($stock) {

            return '<a href="/stock-detail/' . $stock->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/stock-index/' . $stock->id . '"><i class="fal fa-trash"></i></button>'; 
        })

        ->addColumn('created_at', function ($stock) {

            return date(' d/m/Y ', strtotime($stock->created_at)); 
        })

        ->editColumn('stock_name', function ($stock) {

            return isset($stock->stock_name) ? strtoupper($stock->stock_name) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('created_by', function ($stock) {

            return isset($stock->user->name) ? $stock->user->name : '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('status', function ($stock) {

            if($stock->status=='3')
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$stock->invStatus->status_name.'</b></div>';
            }
            else 
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>'.$stock->invStatus->status_name.'</b></div>';
            }
        })
        
        ->rawColumns(['action', 'status', 'created_by', 'stock_name', 'created_at'])
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
        $image = StockImage::where('stock_id', $id)->first();
        $status = InventoryStatus::whereIn('id', ['3','4'])->get();
        $transIn = StockTransaction::where('stock_id', $id)->latest()->first();

        return view('inventory.stock-detail', compact('stock', 'image', 'status', 'transIn'))->with('no', 1);
    }

    public function stockUpdate(Request $request)
    {
        $stock = Stock::where('id', $request->id)->first();

        $request->validate([
            'stock_name'        => 'required',
            'model'             => 'required',
        ]);

        $stock->update([
            'stock_name'            => $request->stock_name, 
            'model'                 => $request->model,
            'brand'                 => $request->brand,
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
        $transIn = StockTransaction::where('stock_id', $request->id)->latest()->first();

        if(isset($transIn))
        {
            $balance = $request->trans_in - $request->trans_out;
            $current_balance = $transIn->current_balance + $request->trans_in;

            $request->validate([
                'lo_no'           => 'required',
                'io_no'           => 'required',
                'trans_in'        => 'required',
                'unit_price'      => 'required',
                'trans_date'      => 'required',
            ]);
    
            $stockIn = StockTransaction::create([
                'stock_id'         => $request->id,
                'lo_no'            => $request->lo_no, 
                'io_no'            => $request->io_no,
                'trans_date'       => $request->trans_date,
                'trans_in'         => $request->trans_in,
                'trans_out'        => $request->trans_in - $balance,
                'current_balance'  => $current_balance,
                'unit_price'       => $request->unit_price,
                'created_by'       => $user->id,
                'remark'           => $request->remark,
                'status'           => '1',
            ]);

        } else {

            $request->validate([
                'lo_no'           => 'required',
                'io_no'           => 'required',
                'trans_in'        => 'required',
                'unit_price'      => 'required',
                'trans_date'      => 'required',
            ]);
    
            $stockIn = StockTransaction::create([
                'stock_id'         => $request->id,
                'lo_no'            => $request->lo_no, 
                'io_no'            => $request->io_no,
                'trans_date'       => $request->trans_date,
                'trans_in'         => $request->trans_in,
                'trans_out'        => '0',
                'current_balance'  => $request->trans_in,
                'unit_price'       => $request->unit_price,
                'created_by'       => $user->id,
                'remark'           => $request->remark,
                'status'           => '1',
            ]);

        }
        
        Session::flash('msg', 'Transaction In Details Successfully Updated');
        return redirect('stock-detail/'.$request->id);
    }

    public function createTransOut(Request $request)
    {
        $user = Auth::user();
        $transOut = StockTransaction::where('stock_id', $request->id)->latest()->first();
        $current_balance = $transOut->current_balance - $request->trans_out;
        $balance = $current_balance + $request->trans_out - $transOut->current_balance;
        
        $request->validate([
            'trans_out'        => 'required',
            // 'trans_date'      => 'trans_date',
        ]);

        $stockIn = StockTransaction::create([
            'stock_id'         => $request->id,
            // 'trans_date'       => $request->trans_date,
            'trans_in'         => $balance,
            'trans_out'        => $request->trans_out,
            'current_balance'  => $current_balance,
            'created_by'       => $user->id,
            'remark'           => $request->remark,
            'status'           => '0',
        ]);

        Session::flash('noty', 'Transaction Out Details Successfully Updated');
        return redirect('stock-detail/'.$request->id);
    }

    public function stockPdf(Request $request, $id)
    {
        $stock = Stock::where('id', $id)->first(); 
        $image = StockImage::where('stock_id', $id)->first();
        return view('inventory.stock-pdf', compact('stock', 'image'))->with('no', 1);
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

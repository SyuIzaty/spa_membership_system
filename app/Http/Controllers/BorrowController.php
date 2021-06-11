<?php

namespace App\Http\Controllers;
use App\AssetDepartment;
use App\Asset;
use App\User;
use App\Borrow;
use App\BorrowStatus;
use Carbon\Carbon;
use Session;
use Response;
use Auth;
use File;
use DB;

use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function borrowIndex()
    {  
        return view('inventory.borrow-index');
    }

    public function borrowNew()
    {
        $department = AssetDepartment::all();
        $user = User::all();

        $asset = new Asset();
        $borrow = new Borrow();
        return view('inventory.borrow-new', compact('department', 'asset', 'user', 'borrow'));
    }

    public function findUsers(Request $request)
    {
        $data = User::select('id', 'name')
            ->where('id',$request->id)
            ->with(['staff'])
            ->first();

        return response()->json($data);
    }

    public function findAsset(Request $request)
    {
        $data2 = Asset::select('id', 'asset_code')
            ->where('status', '1')
            ->where('asset_type',$request->id)
            ->get();

        return response()->json($data2);
    }

    public function findAssets(Request $request)
    {
        $data = Asset::select('id', 'asset_name', 'serial_no', 'model', 'brand', 'storage_location')
            ->where('id',$request->id)
            ->first();

        return response()->json($data);
    }

    public function newBorrowStore(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'asset_code'      => 'required',
            'borrower_name'   => 'required',
            'borrow_date'     => 'required',
        ]);

        $borrow = Borrow::create([
            'asset_id'            => $request->asset_code, 
            'borrower_id'         => $request->borrower_id, 
            'borrow_date'         => $request->borrow_date,
            'return_date'         => $request->return_date,
            'status'              => '1',
            'created_by'          => $user->id,
            'remark'              => $request->remark,
        ]);

        $asset = Asset::where('id', $request->asset_code)->first();

        $asset->update([
            'status'              => '0',
        ]);
            
        Session::flash('message', 'New Borrower Data Have Been Successfully Recorded');
        return redirect('/borrow-index');
    }

    public function data_borrowList()
    {
        $borrow = Borrow::all();

        return datatables()::of($borrow)
        ->addColumn('action', function ($borrow) {

            return '<a href="/borrow-detail/' . $borrow->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/borrow-index/' . $borrow->id . '"><i class="fal fa-trash"></i></button>'; 
        })

        ->addColumn('borrow_date', function ($borrow) {

            return isset($borrow->borrow_date) ? date(' d/m/Y ', strtotime($borrow->borrow_date)) : '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('return_date', function ($borrow) {

            return isset($borrow->return_date) ? date(' d/m/Y ', strtotime($borrow->return_date)) : '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($borrow) {

            return isset($borrow->asset->type->asset_type) ? strtoupper($borrow->asset->type->asset_type) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code', function ($borrow) {

            return isset($borrow->asset->asset_code) ? strtoupper($borrow->asset->asset_code) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($borrow) {

            return isset($borrow->asset->asset_name) ? strtoupper($borrow->asset->asset_name) : '<div style="color:red;" >--</div>';
        })
        
        ->editColumn('status', function ($borrow) {

            if($borrow->status=='1')
            {
                $color = '#CC0000';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>CHECK-OUT</b></div>';
            }
            else 
            {
                $color = '#3CBC3C';
                return '<div style="text-transform: uppercase; color:' . $color . '"><b>RETURNED</b></div>';
            }
        })

        ->editColumn('created_by', function ($borrow) {

            return isset($borrow->user->name) ? $borrow->user->name : '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('borrower_id', function ($borrow) {

            return isset($borrow->borrower->staff_name) ? $borrow->borrower->staff_name : '<div style="color:red;" >--</div>'; 
        })
        
        ->rawColumns(['action', 'status', 'borrow_date', 'return_date', 'asset_code', 'created_by', 'asset_type', 'asset_name', 'borrower_id'])
        ->make(true);
    }

    public function borrowDelete($id)
    {
        $exist = Borrow::find($id);
        $exist->delete();
        return response()->json(['success'=>'Borrow Deleted Successfully']);
    }

    public function borrowDetail($id)
    {
        $borrow = Borrow::where('id', $id)->first(); 
        $status = BorrowStatus::all();

        return view('inventory.borrow-detail', compact('borrow', 'status'));
    }

    public function borrowUpdate(Request $request)
    {
        $borrow = Borrow::where('id', $request->id)->first();

        $request->validate([
            'borrow_date'   => 'required',
            'return_date'   => 'required',
            'status'        => 'required',
        ]);

        $borrow->update([
            'borrow_date'   => $request->borrow_date,
            'return_date'   => $request->return_date,
            'remark'        => $request->remark,
            'status'        => $request->status,
        ]);

        if($request->status == '2')
        {
            $asset = Asset::where('id', $borrow->asset_id)->first();

            $asset->update([
                'status'        => '1',
            ]);
        }

        Session::flash('notification', 'Borrow Details Successfully Updated');
        return redirect('borrow-detail/'.$request->id);
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

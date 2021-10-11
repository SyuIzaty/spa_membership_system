<?php

namespace App\Http\Controllers;
use App\AssetDepartment;
use App\Asset;
use App\User;
use App\Borrow;
use App\BorrowStatus;
use App\AssetCustodian;
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
        
        $user = User::orderBy('name')->get();
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
            ->orderBy('asset_code')
            ->where('availability', '2')
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
            'return_date'     => 'required',
            'reason'          => 'required',
        ]);

        $borrow = Borrow::create([
            'asset_id'            => $request->asset_code, 
            'borrower_id'         => $request->borrower_id, 
            'borrow_date'         => $request->borrow_date,
            'return_date'         => $request->return_date,
            'status'              => '1',
            'created_by'          => $user->id,
            'reason'              => $request->reason,
        ]);

        $asset = Asset::where('id', $request->asset_code)->first();

        $asset->update([
            'availability'              => '1',
        ]);
            
        Session::flash('message', 'New Borrower Data Have Been Successfully Recorded');
        return redirect('/borrow-index');
    }

    public function data_borrowList()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $borrow = Borrow::all();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');
            
            $borrow = Borrow::whereHas('asset', function($q) use ($as){
                $q->whereHas('type',function($q) use ($as){
                    $q->whereHas('department', function($q) use ($as){
                        $q->whereIn('id', $as);
                    });
                });
            });
        }

        return datatables()::of($borrow)
        ->addColumn('action', function ($borrow) {

            return '<div class="btn-group"><a href="/borrow-detail/' . $borrow->id.'" class="btn btn-sm btn-primary mr-1"><i class="fal fa-eye"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/borrow-index/' . $borrow->id . '"><i class="fal fa-trash"></i></button></div>'; 
        })

        ->addColumn('borrow_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->borrow_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('return_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->return_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($borrow) {

            return strtoupper($borrow->asset->type->asset_type) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code', function ($borrow) {

            return strtoupper($borrow->asset->asset_code) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($borrow) {

            return strtoupper($borrow->asset->asset_name) ?? '<div style="color:red;" >--</div>';
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

            return $borrow->user->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('borrower_id', function ($borrow) {

            return $borrow->borrower->staff_name ?? '<div style="color:red;" >--</div>'; 
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
        $user = User::orderBy('name')->get();
        $borrow = Borrow::where('id', $id)->first(); 
        $status = BorrowStatus::all();

        return view('inventory.borrow-detail', compact('borrow', 'status', 'user'));
    }

    public function borrowUpdate(Request $request)
    {
        $borrow = Borrow::where('id', $request->id)->first();

        if(is_null($request->verified_by) && is_null($request->actual_return_date))
        {
            $request->validate([
                'borrow_date'            => 'required',
                'return_date'            => 'required',
                'reason'                 => 'required',
            ]);
    
            $borrow->update([
                'borrow_date'          => $request->borrow_date,
                'return_date'          => $request->return_date,
                'reason'               => $request->reason,
            ]);
        } else {
            $request->validate([
                'borrow_date'            => 'required',
                'return_date'            => 'required',
                'reason'                 => 'required',
                'verified_by'            => 'required',
                'actual_return_date'     => 'required',
            ]);
    
            $borrow->update([
                'borrow_date'          => $request->borrow_date,
                'return_date'          => $request->return_date,
                'reason'               => $request->reason,
                'actual_return_date'   => $request->actual_return_date,
                'verified_by'          => $request->verified_by,
                'remark'               => $request->remark,
                'status'               => '2',
            ]);

            $asset = Asset::where('id', $borrow->asset_id)->first();

            $asset->update([
                'availability'        => '2',
            ]);

        }
    
        Session::flash('notification', 'Borrow Details Successfully Updated');
        return redirect('borrow-detail/'.$request->id);
    }

    public function monitorList()
    {  
        return view('inventory.monitor-list');
    }

    public function data_monitorList()
    {
        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $borrow = Borrow::where('status', '1');
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');
            
            $borrow = Borrow::whereHas('asset', function($q) use ($as){
                $q->whereHas('type',function($q) use ($as){
                    $q->whereHas('department', function($q) use ($as){
                        $q->whereIn('id', $as);
                    });
                });
            })->where('status', 1);
        }

        return datatables()::of($borrow)
        ->addColumn('action', function ($borrow) {
           
            return '<div class="btn-group"><a href="/borrow-detail/' . $borrow->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a></div>'; 
        })

        ->addColumn('borrow_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->borrow_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('return_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->return_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($borrow) {

            return strtoupper($borrow->asset->type->asset_type) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code', function ($borrow) {

            return strtoupper($borrow->asset->asset_code) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($borrow) {

            return strtoupper($borrow->asset->asset_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('created_at', function ($borrow) {

            $delay = Carbon::parse($borrow->return_date)->diffInDays(Carbon::now())+1;

            if($delay != 1){
                return $delay . ' days';
            } else {
                return $delay . ' day';
            }
          
            return $delay;
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

        ->editColumn('borrower_id', function ($borrow) {

            return $borrow->borrower->staff_name ?? '<div style="color:red;" >--</div>'; 
        })
        
        ->rawColumns(['action', 'status', 'borrow_date', 'return_date', 'asset_code', 'asset_type', 'asset_name', 'borrower_id'])
        ->make(true);
    }

    public function borrow_all(Request $request)
    {
        $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $asset = Asset::select('id', 'asset_code', 'asset_name')->get();
        }
        else
        {
            $asset = Asset::whereHas('type',function($q) use ($as){
                $q->whereHas('department', function($q) use ($as){
                    $q->whereIn('id', $as);
                });
            })->get();
        }

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $borrower = Borrow::select('borrower_id')->groupBy('borrower_id')->get();
        }
        else
        {
            $borrower = Borrow::select('borrower_id')->groupBy('borrower_id')->whereHas('asset', function($q) use ($as){
                $q->whereHas('type',function($q) use ($as){
                    $q->whereHas('department', function($q) use ($as){
                        $q->whereIn('id', $as);
                    });
                });
            })->get();
        }

        $status = BorrowStatus::select('id', 'status_name')->get();
        
        $cond = "1"; // 1 = selected

        $selectedasset = $request->asset; 
        $selectedborrower = $request->borrower; 
        $selectedstatus = $request->status; 
        $list = [];

        return view('inventory.borrow-report', compact('request', 'asset', 'borrower', 'status', 'selectedasset', 'selectedborrower', 'selectedstatus', 'list'));
    }

    public function exports($asset = null, $borrower = null, $status = null)
    {
        return Excel::download(new AssetExport($asset, $borrower, $status), 'Borrow.xlsx');
    }

    public function data_borrowexport(Request $request) 
    {
        $cond = "1";
        if($request->asset && $request->asset != "All")
        {
            $cond .= " AND asset_id = '".$request->asset."' ";
        }

        if( $request->borrower != "" && $request->borrower != "All")
        {
            $cond .= " AND borrower_id = '".$request->borrower."' ";
        }

        if( $request->status != "" && $request->status != "All")
        {
            $cond .= " AND status = '".$request->status."' ";
        }

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $borrow = Borrow::whereRaw($cond);
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');
            
            $borrow = Borrow::whereHas('asset', function($q) use ($as){
                $q->whereHas('type',function($q) use ($as){
                    $q->whereHas('department', function($q) use ($as){
                        $q->whereIn('id', $as);
                    });
                });
            })->whereRaw($cond);
        }

        return datatables()::of($borrow)

        ->addColumn('borrow_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->borrow_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('return_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->return_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('created_at', function ($borrow) {

            return date(' d/m/Y | h:i A ', strtotime($borrow->created_at)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->addColumn('actual_return_date', function ($borrow) {

            return date(' d/m/Y ', strtotime($borrow->actual_return_date)) ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('asset_type', function ($borrow) {

            return strtoupper($borrow->asset->type->asset_type) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_code', function ($borrow) {

            return strtoupper($borrow->asset->asset_code) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('asset_name', function ($borrow) {

            return strtoupper($borrow->asset->asset_name) ?? '<div style="color:red;" >--</div>';
        })

        ->editColumn('reason', function ($borrow) {

            return isset($borrow->reason) ? strtoupper($borrow->reason) : '<div style="color:red;" >--</div>';
        })

        ->editColumn('remark', function ($borrow) {

            return isset($borrow->remark) ? strtoupper($borrow->remark) : '<div style="color:red;" >--</div>';
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

            return $borrow->user->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('verified_by', function ($borrow) {

            return $borrow->users->name ?? '<div style="color:red;" >--</div>'; 
        })

        ->editColumn('borrower_id', function ($borrow) {

            return $borrow->borrower->staff_name ?? '<div style="color:red;" >--</div>'; 
        })
    
       ->rawColumns(['borrower_id', 'verified_by', 'created_by', 'status', 'remark', 'reason', 'asset_name', 'asset_code', 'asset_type', 'actual_return_date', 'created_at', 'return_date', 'borrow_date'])
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

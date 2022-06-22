<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AssetCustodian;
use App\AssetDepartment;
use App\AssetType;
use App\Asset;
use App\User;
use Session;
use DB;

class AssetCustodianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $department = DB::table('inv_department as a')
                ->select(DB::raw('a.id, a.department_name, b.department_id, count(b.department_id) as total'))
                ->leftJoin('inv_asset_custodian as b','b.department_id','=','a.id')
                ->orderBy('a.department_name')
                ->whereNull('a.deleted_at')
                ->whereNull('b.deleted_at')
                ->groupBy('a.id','a.department_name','b.department_id')
                ->get();
         
        return view('inventory.asset-custodian.index', compact('department'))->with('no', 1);
    }

    public function addDepartment(Request $request)
    {
        $department = AssetDepartment::where('id', $request->id)->first();

        $request->validate([
            'department_name'      => 'required|max:255',
        ]);

        AssetDepartment::create([
                'department_name'        => $request->department_name, 
            ]);
        
       return redirect('asset-custodian');
    }

    public function custodianList($id)
    {
        $department = AssetDepartment::where('id', $id)->first();
        $data = AssetCustodian::where('department_id', $id)->first(); 

        if(isset($data))
        {
            $data2 = AssetCustodian::where('department_id', $id)->get(); 
            $data3 = array_column($data2->toArray(), 'custodian_id');
            $members =  User::where('id', '!=', $data->custodian_id)->whereNotIn('id', $data3)->whereHas('roles', function($query){
                $query->where('id', 'INV002');
            })->get(); 
        } else {
            $members = User::whereHas('roles', function($query){
                $query->where('id', 'INV002');
            })->get();
        }

        $custodian = AssetCustodian::where('department_id', $id)->get();
        return view('inventory.asset-custodian.details', compact('department','members','custodian'));
    }

    public function storeDepartCust(Request $request)
    {
        $clo = AssetDepartment::where('id', $request->ids)->first();

        foreach($request->input('custodian_id') as $key => $value) {
            AssetCustodian::create([
                'department_id'        => $clo->id,
                'custodian_id'         => $value,
            ]);
        }

        Session::flash('message', 'New Manager Is Added');
        return redirect('custodian-list/'.$request->ids);
    }

    public function deleteCustodian($id)
    {
        $depart = AssetCustodian::where('id', $id)->first();

        $exist = AssetCustodian::find($id);
        $exist->delete();

        return redirect('custodian-list/'.$depart->department_id);
    }

    public function deleteDepartment($id)
    {
        $exist = AssetDepartment::find($id);
        $exist->delete();

        return redirect('asset-custodian');
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

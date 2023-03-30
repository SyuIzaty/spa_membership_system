<?php

namespace App\Http\Controllers;
use App\EquipmentStaff;
use App\EquipmentRent;
use App\Staff;
use intec_iids_dev;
use Auth;
use Illuminate\Http\Request;
use App\Equipment;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff=Staff::where('staff_id', Auth::user()->id)->first();
        $equipment=Equipment::all(); //name model;
        return view('test.test',compact('equipment','staff'));
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
        $data = EquipmentStaff::create([ //store in equipment staff and take it from user
            'staff_id'     => Auth::user()->id, 
            'hp_no' => $request->hpno,
            'rent_date' => $request->rentdate, //store
            'return_date' => $request->retdate,
            'purpose' => $request->purpose,
            'room_no' => $request->room_no
        ]);
            foreach($request->sn as $test => $value){ 
                if(isset($value)){
                    EquipmentRent::create([
                'users_id'     => $data->id,
                'equipments_id'     =>$test, //used to store the ID of the equipment
                'ser_no'     => $value, //to store a single piece of information specific to the rented equipment 
                'desc' => $request->des[$test] 
    
                    ]);
                }
                
            }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $equipment = Equipment::all();
        $equipment_rent = EquipmentRent::all();
        $user = EquipmentStaff::all(); //search one user 

        return view('test.view_record', compact('equipment', 'equipment_rent','user'));
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipments = Equipment::all();
        $user = EquipmentStaff::where('id',$id)->first(); //search one user 
        $staff = Staff::where('staff_id',$user->staff_id)->first(); //query(eloquent) 
        $rent = EquipmentRent::where('users_id',$id)->get(); //retrive data in equipment rent (more than 1)
        // $name = $staff->staff_name;

        // Pass the equipment record to the edit_record view
        return view('test.edit_record', compact('user','staff','equipments','rent','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateApplication(Request $request)
    {
        $user = EquipmentStaff::where('id',$request->id)->first(); //search one user 
        $user->update([
            'purpose' => $request->purpose
        ]);
        // Redirect the user back to the index page 
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function declareDelete($id)
    {
        $delRent=EquipmentRent::where('users_id',$id)->get(); //get the equipment data

        foreach($delRent as $delRents) 
        {
            $delRents->delete();
        }

        $data=EquipmentStaff::find($id); //get the equipment staff data
        $data->delete();
        $data=EquipmentRent::find($users_id);
        $data->delete();
        return response()->json(['success'=>'Declaration Form Successfully Deleted']);
    }


    public function data_rental(Request $request){ //declaration 

        $equipment_rent = EquipmentStaff::orderBy('id', 'desc')->get();

        return datatables()->of($equipment_rent)
            ->editColumn('sid', function ($equipment_rent) {
                return isset($equipment_rent->id) ? $equipment_rent->id : "";
            })
            ->editColumn('staff', function ($equipment_rent) {
                return isset($equipment_rent->staff_id) ? $equipment_rent->staff_id : "";
            })
            ->editColumn('phone', function ($equipment_rent) {
                return isset($equipment_rent->hp_no) ? $equipment_rent->hp_no : "";
            })
            ->editColumn('renDate', function ($equipment_rent) {
                return isset($equipment_rent->rent_date) ? $equipment_rent->rent_date : "";
            })
            ->editColumn('retDate', function ($equipment_rent) {
                return isset($equipment_rent->return_date) ? $equipment_rent->return_date : "";
            })
            ->editColumn('pur', function ($equipment_rent) {
                return isset($equipment_rent->purpose) ? $equipment_rent->purpose : "";
            })
            ->addColumn('action', function ($equipment_rent) {
                return '<div class="btn-group"><a href="/edit_record/' . $equipment_rent->id . '" class="btn btn-warning btn-sm mr-1"><i class="ni ni-note"></i> </a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="declareDelete/' . $equipment_rent->id . '"><i class="fal fa-trash"></i> </button></div>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            }
}


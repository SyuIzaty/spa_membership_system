<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('admin-display.staff');
    }

    public function dataStaff()
    {
        $stf = Staff::all();

        return datatables()::of($stf)

        ->addColumn('action', function ($stf) {

            return '<a href="" data-target="#crud-modals" data-toggle="modal" data-staff="'.$stf->id.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-staff/' . $stf->id . '"><i class="fal fa-trash"></i></button>';
        })

        ->addColumn('staff_status', function ($stf) {

             if(isset($stf->staff_end_date)){

                $status = '<b style="color:red">Inactive</b>';
             } else {
                $status = '<b style="color:green">Active</b>';
             }

             return $status;
        })

        ->addColumn('role_id', function ($stf) {

            if($stf->user->role_id == 'SPA001'){

               $role = 'Administrator';
            } else {
               $role = 'Staff';
            }

            return $role;
       })

        ->addIndexColumn()
        ->rawColumns(['action', 'staff_status','role_id'])
        ->make(true);
    }

    public function getStaff($id)
    {
        $staff = Staff::where('id', $id)->with(['user'])->first();

        return response()->json($staff);
    }

    public function storeStaff(Request $request)
    {
        $userId = date('Y') . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2)) . rand(1000, 9999);

        $username = strstr($request->staff_email, '@', true);

        $defaultPassword = bcrypt('Abcd@1234');

        $user = User::create([
            'id'        => $userId,
            'username'  => $username,
            'password'  => $defaultPassword,
            'role_id'   => $request->role_id,
        ]);

        Staff::create([
            'user_id'          => $user->id,
            'staff_name'       => $request->staff_name,
            'staff_ic'         => $request->staff_ic,
            'staff_email'      => $request->staff_email,
            'staff_phone'      => $request->staff_phone,
            'staff_gender'     => $request->staff_gender,
            'staff_address'    => $request->staff_address,
            'staff_state'      => $request->staff_state,
            'staff_postcode'   => $request->staff_postcode,
            'staff_start_date' => $request->staff_start_date,
            'staff_end_date'   => $request->staff_end_date,
        ]);

        Session::flash('message', 'Staff added successfully.');

        return redirect()->back();
    }

    public function updateStaff(Request $request)
    {
        $stf = Staff::find($request->staff_id);

        if (!$stf) {
            return redirect()->back()->with('error', 'Staff not found.');
        }

        $stf->staff_name        = $request->name;
        $stf->staff_ic          = $request->ic;
        $stf->staff_phone       = $request->phone;
        $stf->staff_gender      = $request->gender;
        $stf->staff_address     = $request->address;
        $stf->staff_state       = $request->state;
        $stf->staff_postcode    = $request->postcode;
        $stf->staff_start_date  = $request->start;
        $stf->staff_end_date    = $request->end;

        $stf->save();

        if ($stf->user) {
            $user           = $stf->user;
            $user->role_id  = $request->role;
            $user->save();
        }

        Session::flash('message', 'Staff updated successfully.');

        return redirect()->back();
    }

    public function deleteStaff($id)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            return response()->json(['message' => 'Staff not found'], 404);
        }

        if ($staff->user) {
            $staff->user->delete();
        }

        $staff->delete();

        return response()->json(['message' => 'Staff deleted successfully']);
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

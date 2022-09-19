<?php

namespace App\Http\Controllers;

use File;
use App\User;
use DateTime;
use Response;
use App\Staff;
use App\Student;
use Carbon\Carbon;
use App\Department;
use App\eKenderaan;
use App\eKenderaanStatus;
use App\eKenderaanDrivers;
use App\eKenderaanRejects;
use App\eKenderaanVehicles;
use Illuminate\Http\Request;
use App\eKenderaanPassengers;
use App\eKenderaanAttachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EKenderaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->category == "STF") {
            $staff =  Staff::where('staff_id', $user->id)->first();
            $name = $staff->staff_name;
            $id = $user->id;
            $deptProg = $staff->staff_dept;
        } elseif ($user->category == "STD") {
            $student =  Student::where('students_id', $user->id)->first();
            $name = $student->students_name;
            $id = $user->id;
            $deptProg = $student->programmes->programme_name;
        }

        $waitingArea = Department::all();

        return view('eKenderaan.form', compact('name', 'id', 'deptProg', 'waitingArea', 'user'));
    }

    public function searchStaff(Request $request)
    {
        $data =  Staff::select('staff_name', 'staff_ic', 'staff_dept')->where('staff_id', $request->id)->first();

        if ($data == '') {
            $data = '';
            return response()->json($data);
        } else {
            return response()->json($data);
        }
    }

    public function applicationList($id)
    {
        $data = eKenderaanStatus::where('id', $id)->first();

        return view('eKenderaan.application-list', compact('data', 'id'));
    }

    public function applicationLists($id)
    {
        $data = eKenderaan::where('status', $id)->get();

        return datatables()::of($data)

        ->editColumn('name', function ($data) {
            if ($data->category == "STF") {
                $details = Staff::where('staff_id', $data->intec_id)->first();

                return isset($details->staff_name) ? $details->staff_name : 'N/A';
            } elseif ($data->category == "STD") {
                $details = Student::where('students_id', $data->intec_id)->first();

                return isset($details->students_name) ? $details->students_name : 'N/A';
            }
        })

        ->editColumn('id', function ($data) {
            return $data->intec_id;
        })

        ->editColumn('progfac', function ($data) {
            if ($data->category == "STF") {
                $details = Staff::where('staff_id', $data->intec_id)->first();

                return isset($details->staff_dept) ? $details->staff_dept : 'N/A';
            } elseif ($data->category == "STD") {
                $details = Student::where('students_id', $data->intec_id)->first();

                return isset($details->programmes->programme_name) ? $details->programmes->programme_name : 'N/A';
            }
        })

        ->editColumn('date_applied', function ($data) {
            $date = new DateTime($data->created_at);
            $dateApplied = $date->format('d-m-Y');

            return $dateApplied;
        })

        ->editColumn('status', function ($data) {
            return $data->statusList->name;
        })

        ->addColumn('action', function ($data) {
            return '<a href="/eKenderaan-application/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addColumn('log', function ($data) {
            return '<a href="/log-eKenderaan/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-list-alt"></i></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action','log'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $departdate = Carbon::createFromFormat('d/m/Y', $request->departdate)->format('Y-m-d');
        $departtime = Carbon::createFromFormat('h:i a', $request->departtime)->format('H:i:s');
        $returndate = Carbon::createFromFormat('d/m/Y', $request->returndate)->format('Y-m-d');
        $returntime = Carbon::createFromFormat('h:i a', $request->returntime)->format('H:i:s');


        $application = eKenderaan::create([
            'intec_id'     => Auth::user()->id,
            'phone_no'     => $request->hp_no,
            'depart_date'  => $departdate,
            'depart_time'  => $departtime,
            'return_date'  => $returndate,
            'return_time'  => $returntime,
            'destination'  => $request->destination,
            'waiting_area' => $request->waitingarea,
            'purpose'      => $request->purpose,
            'status'       => '1',
            'category'     => Auth::user()->category,
            'created_by'   => Auth::user()->id
        ]);

        if ($request->staff_id) {
            foreach ($request->staff_id as $key => $value) {
                if ($request->staff_id[$key] != null) {
                    eKenderaanPassengers::create([
                        'ekn_details_id' => $application->id,
                        'intec_id'       => $request->staff_id[$key],
                        'category'       => 'STF',
                        'created_by'   => Auth::user()->id
                        ]);
                }
            }
        }
        if ($request->student_id) {
            foreach ($request->student_id as $key => $value) {
                if ($request->student_id[$key] != null) {
                    eKenderaanPassengers::create([
                        'ekn_details_id' => $application->id,
                        'intec_id'       => $request->student_id[$key],
                        'category'       => 'STD',
                        'created_by'   => Auth::user()->id
                        ]);
                }
            }
        }

        $file = $request->file('attachment');

        if (isset($file)) {
            $originalName = time().$file->getClientOriginalName();
            $request->file('attachment')->storeAs('eKenderaan', $originalName, 'minio');
            eKenderaanAttachments::create([
                'ekn_details_id' => $application->id,
                'upload'         => $originalName,
                'web_path'       => "eKenderaan/".$originalName,
                'created_by'     => Auth::user()->id
            ]);
        }
        return redirect('eKenderaan-application/'.$application->id)->with('message', 'Application Sent!');
    }

    public function show($id)
    {
        $data = EKenderaan::where('id', $id)->first();

        if ($data->category == "STF") {
            $details = Staff::where('staff_id', $data->intec_id)->first();
            $name = $details->staff_name;
            $progfac = $details->staff_dept;
        } elseif ($data->category == "STD") {
            $details = Student::where('students_id', $data->intec_id)->first();
            $name = $details->students_name;
            $progfac = $details->programmes->programme_name;
        }

        $departdate = Carbon::createFromFormat('Y-m-d', $data->depart_date)->format('d/m/Y');
        $departtime = Carbon::createFromFormat('H:i:s', $data->depart_time)->format('h:i a');
        $returndate = Carbon::createFromFormat('Y-m-d', $data->return_date)->format('d/m/Y');
        $returntime = Carbon::createFromFormat('H:i:s', $data->return_time)->format('h:i a');

        $passenger  = eKenderaanPassengers::where('ekn_details_id', $id)->get();
        $driver = eKenderaanDrivers::all();
        $vehicle = eKenderaanVehicles::all();
        $file = eKenderaanAttachments::where('ekn_details_id', $id)->first();
        $remark = eKenderaanRejects::where('ekn_details_id', $id)->first();

        return view('eKenderaan.details', compact(
            'id',
            'data',
            'name',
            'progfac',
            'departdate',
            'departtime',
            'returndate',
            'returntime',
            'passenger',
            'driver',
            'vehicle',
            'file',
            'remark'
        ));
    }

    public function file($id)
    {
        $file = eKenderaanAttachments::where('id', $id)->first();
        $filename = $file->upload;
        return Storage::response('eKenderaan/'.$filename);
    }

    public function passenger($id)
    {
        $data  = eKenderaanPassengers::where('ekn_details_id', $id)->get();

        return datatables()::of($data)

        ->editColumn('name', function ($data) {
            if ($data->category == "STF") {
                $details = Staff::where('staff_id', $data->intec_id)->first();

                return isset($details->staff_name) ? $details->staff_name : 'N/A';
            } elseif ($data->category == "STD") {
                $details = Student::where('students_id', $data->intec_id)->first();

                return isset($details->students_name) ? $details->students_name : 'N/A';
            }
        })

        ->editColumn('progfac', function ($data) {
            if ($data->category == "STF") {
                $details = Staff::where('staff_id', $data->intec_id)->first();

                return isset($details->staff_dept) ? $details->staff_dept : 'N/A';
            } elseif ($data->category == "STD") {
                $details = Student::where('students_id', $data->intec_id)->first();

                return isset($details->programmes->programme_name) ? $details->programmes->programme_name : 'N/A';
            }
        })

        ->editColumn('ic', function ($data) {
            if ($data->category == "STF") {
                $details = Staff::where('staff_id', $data->intec_id)->first();

                return isset($details->staff_ic) ? $details->staff_ic : 'N/A';
            } elseif ($data->category == "STD") {
                $details = Student::where('students_id', $data->intec_id)->first();

                return isset($details->students_ic) ? $details->students_ic : 'N/A';
            }
        })

        ->editColumn('id', function ($data) {
            return $data->intec_id;
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function verifyApplication(Request $request)
    {
        $data =EKenderaan::where('id', $request->id)->first();
        $data->update([
            'hod_hop_approval' => 'Y',
            'status' => '2',
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Verified!');
    }

    public function rejectApplication(Request $request)
    {
        $data = EKenderaan::where('id', $request->id)->first();
        $data->update([
            'hod_hop_approval' => 'N',
            'status' => '4',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanRejects::create([
            'ekn_details_id' => $request->id,
            'remark' => $request->remark,
            'category' => 'HOD/HOP',
            'created_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Rejected!');
    }

    public function operationVerifyApplication(Request $request)
    {
        $data =EKenderaan::where('id', $request->id)->first();
        $data->update([
            'operation_approval' => 'Y',
            'driver' => $request->driver,
            'vehicle' => $request->vehicle,
            'status' => '3',
            'updated_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Verified!');
    }

    public function operationRejectApplication(Request $request)
    {
        $data = EKenderaan::where('id', $request->id)->first();
        $data->update([
            'operation_approval' => 'N',
            'status' => '4',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanRejects::create([
            'ekn_details_id' => $request->id,
            'remark' => $request->remark,
            'category' => 'OPR',
            'created_by' => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Rejected!');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\eKenderaan  $eKenderaan
     * @return \Illuminate\Http\Response
     */
    public function edit(eKenderaan $eKenderaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\eKenderaan  $eKenderaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eKenderaan $eKenderaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\eKenderaan  $eKenderaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(eKenderaan $eKenderaan)
    {
        //
    }
}

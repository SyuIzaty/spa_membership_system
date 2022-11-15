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
use App\Programmes;
use App\Departments;
use App\eKenderaanLog;
use App\eKenderaanStatus;
use App\eKenderaanDrivers;
use App\eKenderaanRejects;
use App\eKenderaanFeedback;
use App\eKenderaanVehicles;
use Illuminate\Http\Request;
use App\eKenderaanPassengers;
use App\eKenderaanAttachments;
use App\Exports\eKenderaanExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\eKenderaanExportByYear;
use Illuminate\Support\Facades\Storage;
use App\Exports\eKenderaanExportByYearMonth;

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

    public function application()
    {
        return view('eKenderaan.application');
    }

    public function getList()
    {
        $data = eKenderaan::where('intec_id', Auth::user()->id)->get();

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


    public function applicationList($id)
    {
        $data = eKenderaanStatus::where('id', $id)->first();

        return view('eKenderaan.application-list', compact('data', 'id'));
    }

    public function applicationLists($id)
    {
        if (Auth::user()->hasRole('eKenderaan Admin')) {
            $data = eKenderaan::where('status', $id)->get();
        } elseif (Auth::user()->hasRole('eKenderaan Manager')) {
            $dept = Staff::where('staff_id', Auth::user()->id)->first();
            $staff = Staff::where('staff_code', $dept->staff_code)->get()->pluck('staff_id')->toArray();
            $data = eKenderaan::whereIn('intec_id', $staff)->get();
        } else {
            $program = Programmes::where('head_of_programme', Auth::user()->id)->pluck('id')->toArray();

            $data = eKenderaan::where('status', $id)->whereHas('student', function ($query) use ($program) {
                $query->whereIn('students_programme', $program);
            })->get();
        }

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

        $validated = $request->validate([
            'hp_no'   => 'required|numeric|digits_between:10,11',
            'departdate'   => 'required',
            'departtime'   => 'required',
            'returndate'   => 'required',
            'returntime'   => 'required',
            'destination'  => 'required',
            'waitingarea'  => 'required',
            'purpose'      => 'required',
        ], [
        ]);

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

        eKenderaanLog::create([
            'ekn_details_id'=> $application->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Apply new application',
            'created_by'    => Auth::user()->id
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
            $request->file('attachment')->storeAs('/eKenderaan', $originalName);
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
        $driver = eKenderaanDrivers::where('status', 'Y')->get();
        $vehicle = eKenderaanVehicles::where('status', 'Y')->get();
        $file = eKenderaanAttachments::where('ekn_details_id', $id)->first();
        $remark = eKenderaanRejects::where('ekn_details_id', $id)->first();
        $feedback = eKenderaanFeedback::where('ekn_details_id', $id)->first();

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
            'remark',
            'feedback'
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

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'HOD/HOP verify application',
            'created_by'    => Auth::user()->id
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

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'HOD/HOP reject application',
            'created_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Rejected!');
    }

    public function operationVerifyApplication(Request $request)
    {
        $validated = $request->validate([
            'driver'   => 'required',
            'vehicle'   => 'required',
        ]);

        $data =EKenderaan::where('id', $request->id)->first();
        $data->update([
            'operation_approval' => 'Y',
            'driver' => $request->driver,
            'vehicle' => $request->vehicle,
            'status' => '3',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Operation verify application',
            'created_by'    => Auth::user()->id
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

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Operation reject application',
            'created_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Rejected!');
    }

    public function feedback(Request $request)
    {
        $data =EKenderaan::where('id', $request->id)->first();
        $data->update([
            'status' => '5',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanFeedback::create([
            'ekn_details_id' => $request->id,
            'remark' => $request->feedback,
            'created_by' => Auth::user()->id
        ]);

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Submit feedback',
            'created_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Feedback Successfully Submitted!');
    }

    public function driver()
    {
        return view('eKenderaan.driver');
    }

    public function driverList()
    {
        $driver = eKenderaanDrivers::get();

        return datatables()::of($driver)

            ->editColumn('status', function ($driver) {
                if ($driver->status == 'Y') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('edit', function ($driver) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$driver->id.'" data-name="'.$driver->name.'" data-staff_id="'.$driver->staff_id.'" data-status="'.$driver->status.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['status','edit'])
            ->addIndexColumn()
            ->make(true);
    }

    public function addDriver(Request $request)
    {
        eKenderaanDrivers::create([
            'name'      => $request->name,
            'staff_id'  => $request->staff_id,
            'status'    => $request->status,
            'created_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function editDriver(Request $request)
    {
        $update = eKenderaanDrivers::where('id', $request->id)->first();
        $update->update([
            'name'      => $request->name,
            'staff_id'  => $request->staff_id,
            'status'    => $request->status,
            'updated_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function vehicle()
    {
        return view('eKenderaan.vehicle');
    }

    public function vehicleList()
    {
        $vehicle = eKenderaanVehicles::get();

        return datatables()::of($vehicle)

            ->editColumn('status', function ($vehicle) {
                if ($vehicle->status == 'Y') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('edit', function ($vehicle) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$vehicle->id.'" data-name="'.$vehicle->name.'" data-plate_no="'.$vehicle->plate_no.'" data-status="'.$vehicle->status.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['status','edit'])
            ->addIndexColumn()
            ->make(true);
    }

    public function addVehicle(Request $request)
    {
        eKenderaanVehicles::create([
            'name'      => $request->name,
            'plate_no'  => $request->plate_no,
            'status'    => $request->status,
            'created_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function editVehicle(Request $request)
    {
        $update = eKenderaanVehicles::where('id', $request->id)->first();
        $update->update([
            'name'      => $request->name,
            'plate_no'  => $request->plate_no,
            'status'    => $request->status,
            'updated_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function report()
    {
        $year = eKenderaan::whereIn('status', ['3','5'])
        ->orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })
        ->unique(); //year selection

        return view('eKenderaan.report', compact('year'));
    }

    public function allReport()
    {
        $list = eKenderaan::whereIn('status', ['3','5'])->get();

        return datatables()::of($list)

        ->editColumn('name', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_name) ? $details->staff_name : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->students_name) ? $details->students_name : 'N/A';
            }
        })

        ->editColumn('id', function ($list) {
            return $list->intec_id;
        })

        ->editColumn('progfac', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_dept) ? $details->staff_dept : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->programmes->programme_name) ? $details->programmes->programme_name : 'N/A';
            }
        })

        ->editColumn('hp_no', function ($list) {
            return $list->phone_no;
        })

        ->editColumn('date_applied', function ($list) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $list->created_at)->format('d/m/Y');
            return $date;
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function reportYear(Request $request)
    {
        $list = eKenderaan::whereIn('status', ['3','5'])->whereYear('created_at', '=', $request->year)->get();

        return datatables()::of($list)

        ->editColumn('name', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_name) ? $details->staff_name : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->students_name) ? $details->students_name : 'N/A';
            }
        })

        ->editColumn('id', function ($list) {
            return $list->intec_id;
        })

        ->editColumn('progfac', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_dept) ? $details->staff_dept : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->programmes->programme_name) ? $details->programmes->programme_name : 'N/A';
            }
        })

        ->editColumn('hp_no', function ($list) {
            return $list->phone_no;
        })

        ->editColumn('date_applied', function ($list) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $list->created_at)->format('d/m/Y');
            return $date;
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function reportMonthYear(Request $request)
    {
        $month = date('m', strtotime($request->month));

        $list = eKenderaan::whereIn('status', ['3','5'])->whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $month)->get();

        return datatables()::of($list)

        ->editColumn('name', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_name) ? $details->staff_name : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->students_name) ? $details->students_name : 'N/A';
            }
        })

        ->editColumn('id', function ($list) {
            return $list->intec_id;
        })

        ->editColumn('progfac', function ($list) {
            if ($list->category == "STF") {
                $details = Staff::where('staff_id', $list->intec_id)->first();

                return isset($details->staff_dept) ? $details->staff_dept : 'N/A';
            } elseif ($list->category == "STD") {
                $details = Student::where('students_id', $list->intec_id)->first();

                return isset($details->programmes->programme_name) ? $details->programmes->programme_name : 'N/A';
            }
        })

        ->editColumn('hp_no', function ($list) {
            return $list->phone_no;
        })

        ->editColumn('date_applied', function ($list) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $list->created_at)->format('d/m/Y');
            return $date;
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function getYear($year)
    {
        $month = eKenderaan::whereIn('status', ['3','5'])
                ->whereYear('created_at', '=', $year)
                ->orderBy('created_at', 'ASC')
                ->pluck('created_at')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('F');
                })
                ->unique(); //month selection

        return response()->json($month);
    }

    public function eKenderaanReport()
    {
        return Excel::download(new eKenderaanExport(), 'eKenderaan Full Report.xlsx');
    }

    public function eKenderaanReportYear($year)
    {
        return Excel::download(new eKenderaanExportByYear($year), 'eKenderaan Report '.$year.'.xlsx');
    }

    public function eKenderaanReportYearMonth($year, $month)
    {
        return Excel::download(new eKenderaanExportByYearMonth($year, $month), 'eKenderaan Report '.$month.' '.$year.'.xlsx');
    }

    public function log($id)
    {
        return view('eKenderaan.log', compact('id'));
    }

    public function logList($id)
    {
        $log = eKenderaanLog::where('ekn_details_id', $id)->get();

        return datatables()::of($log)

            ->addColumn('date', function ($log) {
                return $log->created_at->format('d/m/Y g:i A') ?? '';
            })

            ->addIndexColumn()
            ->rawColumns(['date'])
            ->make(true);
    }
}

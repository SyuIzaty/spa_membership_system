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
use App\eKenderaanWaitingArea;
use App\eKenderaanAssignDriver;
use App\eKenderaanAssignVehicle;
use App\Exports\eKenderaanExport;
use App\eKenderaanFeedbackService;
use Illuminate\Support\Facades\DB;
use App\eKenderaanFeedbackQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Input;
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

        $waitingArea = Department::orderBy('department_name', 'ASC')->get();
        $staff = Staff::all();
        $student = Student::where('students_status', 'AKTIF')->get();

        return view('eKenderaan.form', compact('name', 'id', 'deptProg', 'waitingArea', 'user', 'staff', 'student'));
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

    public function findStaffID(Request $request)
    {
        $data = Staff::select('staff_ic', 'staff_name', 'staff_dept')
            ->where('staff_id', $request->id)
            ->first();

        return response()->json($data);
    }

    public function findStudID(Request $request)
    {
        $data = Student::select('*')
                ->where('students_id', $request->id)
                ->with(['programmes'])
                ->first();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $departdate = Carbon::createFromFormat('d/m/Y', $request->departdate)->format('Y-m-d');
        $departtime = Carbon::createFromFormat('h:i a', $request->departtime)->format('H:i:s');
        $returndate = Carbon::createFromFormat('d/m/Y', $request->returndate)->format('Y-m-d');
        $returntime = Carbon::createFromFormat('h:i a', $request->returntime)->format('H:i:s');

        $validated = $request->validate([
            'hp_no'        => 'required|numeric|digits_between:10,11',
            'departdate'   => 'required',
            'departtime'   => 'required',
            'returndate'   => 'required',
            'returntime'   => 'required',
            'destination'  => 'required',
            'purpose'      => 'required',
            'waitingarea'  => 'required_without:others',
        ], [
            'waitingarea.required_without'  => 'The Waiting Area field is required.',

        ]);

        $application               = new eKenderaan();
        $application->intec_id     = Auth::user()->id;
        $application->phone_no     = $request->hp_no;
        $application->depart_date  = $departdate;
        $application->depart_time  = $departtime;
        $application->return_date  = $returndate;
        $application->return_time  = $returntime;
        $application->destination  = $request->destination;
        $application->purpose      = $request->purpose;
        $application->status       = '2';
        $application->category     = Auth::user()->category;
        $application->updated_by   = Auth::user()->id;
        $application->save();


        // $application = eKenderaan::create([
        //     'intec_id'     => Auth::user()->id,
        //     'phone_no'     => $request->hp_no,
        //     'depart_date'  => $departdate,
        //     'depart_time'  => $departtime,
        //     'return_date'  => $returndate,
        //     'return_time'  => $returntime,
        //     'destination'  => $request->destination,
        //     'purpose'      => $request->purpose,
        //     'status'       => '2',
        //     'category'     => Auth::user()->category,
        //     'created_by'   => Auth::user()->id
        // ]);

        eKenderaanLog::create([
            'ekn_details_id'=> $application->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Apply new application',
            'created_by'    => Auth::user()->id
        ]);

        // $errormsg = false;

        // if (empty($request->waitingarea) && empty($request->others)) {
        //     $errormsg = true;
        // } else {
        //     foreach ($request->waitingarea as $key => $value) {
        //         eKenderaanWaitingArea::create([
        //         'ekn_details_id' => $application->id,
        //         'waiting_area'   => $request->waitingarea[$key],
        //         'created_by'     => Auth::user()->id
        //         ]);
        //         if ($request->others != '') {
        //             eKenderaanWaitingArea::create([
        //                 'ekn_details_id' => $application->id,
        //                 'waiting_area'   => $request->others,
        //                 'created_by'     => Auth::user()->id
        //                 ]);
        //         }
        //     }
        // }

        // foreach ($request->waitingarea as $key => $value) {
        //     eKenderaanWaitingArea::create([
        //     'ekn_details_id' => $application->id,
        //     'waiting_area'   => $request->waitingarea[$key],
        //     'created_by'     => Auth::user()->id
        //     ]);
        //     if ($request->others != '') {
        //         eKenderaanWaitingArea::create([
        //             'ekn_details_id' => $application->id,
        //             'waiting_area'   => $request->others,
        //             'created_by'     => Auth::user()->id
        //             ]);
        //     }
        // }

        if ($request->waitingarea) {
            foreach ($request->waitingarea as $key => $value) {
                eKenderaanWaitingArea::create([
                'ekn_details_id' => $application->id,
                'waiting_area'   => $request->waitingarea[$key],
                'created_by'     => Auth::user()->id
                ]);
            }
        }

        if ($request->others) {
            eKenderaanWaitingArea::create([
                'ekn_details_id' => $application->id,
                'waiting_area'   => $request->others,
                'created_by'     => Auth::user()->id
                ]);
        }

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

        if ($request->passenger_staff) {
            foreach ($request->passenger_staff as $key => $value) {
                if ($request->passenger_staff[$key] != null) {
                    eKenderaanPassengers::create([
                        'ekn_details_id' => $application->id,
                        'intec_id'       => $request->passenger_staff[$key],
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

        if ($request->student_id_bulk) {
            foreach ($request->student_id_bulk as $key => $value) {
                if ($request->student_id_bulk[$key] != null) {
                    eKenderaanPassengers::create([
                        'ekn_details_id' => $application->id,
                        'intec_id'       => $request->student_id_bulk[$key],
                        'category'       => 'STD',
                        'created_by'   => Auth::user()->id
                        ]);
                }
            }
        }

        if ($request->passenger_student) {
            foreach ($request->passenger_student as $key => $value) {
                if ($request->passenger_student[$key] != null) {
                    eKenderaanPassengers::create([
                        'ekn_details_id' => $application->id,
                        'intec_id'       => $request->passenger_student[$key],
                        'category'       => 'STD',
                        'created_by'   => Auth::user()->id
                        ]);
                }
            }
        }
        $file = $request->temp_file;

        if ($file != '') {
            eKenderaanAttachments::where('id', $file)->update(['ekn_details_id' => $application->id]);
        }

        $user = Auth::user();

        $admin = User::where('id', '17020362')->first();
        $admin_email = $admin->email;

        $data = [
            'receivers' => $admin->name,
            'emel'      => 'Anda telah menerima permohonan e-Kenderaan baharu daripada '.$user->name.' pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
            'footer'    => 'Sila log masuk ke sistem IDS untuk tindakan selanjutnya.',
        ];

        Mail::send('eKenderaan.email_announcement', $data, function ($message) use ($admin_email) {
            $message->subject('EKENDERAAN: PERMOHONAN BAHARU');
            $message->from('operasi@intec.edu.my');
            $message->to($admin_email);
        });

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

        $departdate       = Carbon::createFromFormat('Y-m-d', $data->depart_date)->format('d/m/Y');
        $departtime       = Carbon::createFromFormat('H:i:s', $data->depart_time)->format('h:i a');
        $returndate       = Carbon::createFromFormat('Y-m-d', $data->return_date)->format('d/m/Y');
        $returntime       = Carbon::createFromFormat('H:i:s', $data->return_time)->format('h:i a');
        $waitingArea      = eKenderaanWaitingArea::where('ekn_details_id', $id)->get();
        $passenger        = eKenderaanPassengers::where('ekn_details_id', $id)->get();
        $file             = eKenderaanAttachments::where('ekn_details_id', $id)->first();
        $remark           = eKenderaanRejects::where('ekn_details_id', $id)->first();
        $feedback         = eKenderaanFeedback::where('ekn_details_id', $id)->first();
        $feedbackQuestion = eKenderaanFeedbackQuestion::where('status', 'Y')->orderBy('sequence', 'ASC')->get();
        $feedbackScale    = eKenderaanFeedbackService::where('ekn_details_id', $id)->get();

        $assignDriver     = eKenderaanAssignDriver::where('ekn_details_id', $id)->get();
        $driver_assign    = array_column($assignDriver->toArray(), 'driver_id');
        $driver           = eKenderaanDrivers::where('status', 'Y')->whereNotIn('id', $driver_assign)->get();

        $assignVehicle    = eKenderaanAssignVehicle::where('ekn_details_id', $id)->get();
        $vehicle_assign   = array_column($assignVehicle->toArray(), 'vehicle_id');
        $vehicle          = eKenderaanVehicles::where('status', 'Y')->whereNotIn('id', $vehicle_assign)->get();

        return view('eKenderaan.details', compact(
            'id',
            'data',
            'name',
            'progfac',
            'departdate',
            'departtime',
            'returndate',
            'returntime',
            'waitingArea',
            'passenger',
            'driver',
            'vehicle',
            'file',
            'remark',
            'feedback',
            'feedbackQuestion',
            'feedbackScale',
            'assignDriver',
            'assignVehicle'
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

    public function operationVerifyApplication(Request $request)
    {
        $validated = $request->validate([
            'driver'   => 'required',
            'vehicle'  => 'required',
        ]);

        $detail = EKenderaan::where('id', $request->id)->first();
        $detail->update([
            'operation_approval' => 'Y',
            'status' => '3',
            'updated_by' => Auth::user()->id
        ]);

        foreach ($request->vehicle as $key => $value) {
            eKenderaanAssignVehicle::create([
                'ekn_details_id'=> $request->id,
                'vehicle_id'    => $value,
                'created_by'    => Auth::user()->id
            ]);
        }

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Operation verify application',
            'created_by'    => Auth::user()->id
        ]);

        $passenger = eKenderaanPassengers::where('ekn_details_id', $request->id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $request->id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $request->id)->get();

        foreach ($request->driver as $key => $value) {
            $application                 = new eKenderaanAssignDriver();
            $application->ekn_details_id = $request->id;
            $application->driver_id      = $value;
            $application->updated_by     = Auth::user()->id;
            $application->save();
        }

        $details = eKenderaanAssignDriver::where('ekn_details_id', $request->id)->get();
        $driver_assign    = array_column($details->toArray(), 'driver_id');
        $drivers           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();

        foreach ($drivers as $d) {
            $user_email = $d->driverDetails->staff_email;

            $data1 = [
                'receivers'   => $d->driverDetails->staff_name,
                'emel'        => 'Untuk makluman, anda telah ditugaskan pada :-',
                'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
                'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
                'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
                'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
                'destination' => $detail->destination,
                'driver'      => $drivers,
                'waitingArea' => $waitingArea,
                'purpose'     => $detail->purpose,
                'passenger'   => $passenger,
                'vehicle'     => $vehicle,
                'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
            ];

            Mail::send('eKenderaan.email', $data1, function ($message) use ($user_email) {
                $message->subject('EKENDERAAN: TUGASAN BAHARU');
                $message->from('operasi@intec.edu.my');
                $message->to($user_email);
            });
        }

        $staff = User::where('id', $detail->intec_id)->first();
        $staff_email =  $staff->email;

        $data2 = [
            'receivers'   => $staff->name,
            'emel'        => 'Untuk makluman, permohonan anda telah diluluskan. Berikut merupakan butiran permohonan:-',
            'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
            'destination' => $detail->destination,
            'driver'      => $drivers,
            'waitingArea' => $waitingArea,
            'purpose'     => $detail->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $data2, function ($message2) use ($staff_email) {
            $message2->subject('EKENDERAAN: PERMOHONAN DILULUSKAN');
            $message2->from('operasi@intec.edu.my');
            $message2->to($staff_email);
        });

        return redirect()->back()->with('message', 'Successfully Verified!');
    }

    public function operationRejectApplication(Request $request)
    {
        $details = EKenderaan::where('id', $request->id)->first();
        $details->update([
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

        $staff = User::where('id', $details->intec_id)->first();
        $staff_email =  $staff->email;

        $data2 = [
            'receivers'   => $staff->name,
            'emel'        => 'Untuk makluman, permohonan anda telah ditolak. Sila log masuk ke sistem IDS untuk melihat sebab penolakan',
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256.',
        ];

        Mail::send('eKenderaan.email_announcement', $data2, function ($message2) use ($staff_email) {
            $message2->subject('EKENDERAAN: PERMOHONAN DITOLAK');
            $message2->from('operasi@intec.edu.my');
            $message2->to($staff_email);
        });

        return redirect()->back()->with('message', 'Rejected!');
    }

    public function feedback(Request $request)
    {
        $validated = $request->validate([
            'rating'   => 'required',
            'scale'    => 'required',
            'feedback' => 'required',
        ], [
        ]);

        $data = EKenderaan::where('id', $request->id)->first();
        $data->update([
            'status' => '5',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanFeedback::create([
            'ekn_details_id' => $request->id,
            'remark' => $request->feedback,
            'created_by' => Auth::user()->id
        ]);

        foreach ($request->rating as $key => $value) {
            eKenderaanAssignDriver::where('id', $key)->update(['rating' => $value]);
        }

        foreach ($request->scale as $key => $v) {
            foreach ($v as $k => $value) {
                eKenderaanFeedbackService::create([
                    'ekn_feedback_questions_id' => $key,
                    'ekn_details_id'            => $request->id,
                    'ekn_assigned_driver_id'    => $k,
                    'scale'                     => $value,
                    'created_by'                => Auth::user()->id
                ]);
            }
        }

        eKenderaanLog::create([
            'ekn_details_id'=> $request->id,
            'name'          => Auth::user()->name,
            'activity'      => 'Submit feedback',
            'created_by'    => Auth::user()->id
        ]);

        $user = Auth::user();

        $admin = User::where('id', '17020362')->first();
        $admin_email = $admin->email;

        $data = [
            'receivers' => $admin->name,
            'emel'      => $user->name.' telah menghantar maklum balas pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
            'footer'    => 'Sila log masuk ke sistem IDS untuk melihat maklum balas tersebut.',
        ];

        Mail::send('eKenderaan.email_announcement', $data, function ($message) use ($admin_email) {
            $message->subject('EKENDERAAN: MAKLUM BALAS BAHARU');
            $message->from('operasi@intec.edu.my');
            $message->to($admin_email);
        });

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
                $id = $driver->id;
                $drivers = eKenderaanAssignDriver::whereHas('driverList', function ($query) use ($id) {
                    $query->where('driver_id', $id);
                })->first();

                if ($drivers != null) {
                    return '';
                } else {
                    return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$driver->id.'" data-name="'.$driver->name.'" data-staff_id="'.$driver->staff_id.'" data-status="'.$driver->status.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
                }
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
                $vehicles = eKenderaanAssignVehicle::whereHas('vehicleList', function ($query) use ($vehicle) {
                    $query->where('vehicle_id', $vehicle->id);
                })->first();

                if ($vehicles != null) {
                    return '';
                } else {
                    return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$vehicle->id.'" data-name="'.$vehicle->name.'" data-plate_no="'.$vehicle->plate_no.'" data-status="'.$vehicle->status.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
                }
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

    public function review(Request $request)
    {
        $staffs = Staff::get();
        $pelajar = Student::where('students_status', 'AKTIF')->get();

        $departdate = $request->departdate;
        $departtime = $request->departtime;
        $returndate = $request->returndate;
        $returntime = $request->returntime;

        $validated = $request->validate([
            'hp_no'   => 'required|numeric|digits_between:10,11',
            'departdate'   => 'required',
            'departtime'   => 'required',
            'returndate'   => 'required',
            'returntime'   => 'required',
            'destination'  => 'required',
            'waitingarea'  => 'required_without:others',
            'purpose'      => 'required',
        ], [
            'waitingarea.required_without'  => 'The Waiting Area field is required.',

        ]);

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

        $user_hp = $request->hp_no;
        $destination = $request->destination;
        $waiting_area = $request->waitingarea;
        $other_waiting_area = $request->others;
        $purpose = $request->purpose;
        $waitingArea = Department::all();

        $file = $request->file('attachment');

        if (isset($file)) {
            $originalName = time().$file->getClientOriginalName();
            $request->file('attachment')->storeAs('/eKenderaan', $originalName);
            $image = eKenderaanAttachments::create([
                'ekn_details_id' => null,
                'upload'         => $originalName,
                'web_path'       => "eKenderaan/".$originalName,
                'created_by'     => Auth::user()->id
            ]);

            $image_id = $image->id;
        } else {
            $image_id = '';
            $originalName = '';
        }
        if ($request->staff_id) {
            $passenger_staff = $request->staff_id;
        } else {
            $passenger_staff = '';
        }

        if ($request->student_id) {
            $passenger_student = $request->student_id;
        } else {
            $passenger_student = '';
        }

        $isError = false;

        $bulkStudent = $request->file('import_file');
        if ($bulkStudent != null) {
            $passengerBulk = (new FastExcel())->import(request()->file('import_file'));

            $passenger = (new FastExcel())->import(request()->file('import_file'), function ($line) use (&$isError) {
                if (!isset($line['ID'])) {
                    $isError = true;
                }
            });
        } else {
            $passengerBulk = '';
        }

        if ($isError) {
            return redirect()->back()->withInput()->withErrors("Bulk Student File format is not accurate. Please refer to the reference");
        } else {
            return view('eKenderaan.details-review', compact(
                'staffs',
                'pelajar',
                'user',
                'departdate',
                'departtime',
                'returndate',
                'returntime',
                'id',
                'name',
                'deptProg',
                'user_hp',
                'destination',
                'waiting_area',
                'other_waiting_area',
                'purpose',
                'image_id',
                'originalName',
                'passengerBulk',
                'waitingArea',
                'passenger_staff',
                'passenger_student'
            ));
        }
    }

    public function getFile()
    {
        $file = "Student List Excel Format.png";

        $path = storage_path().'/ekenderaan/'.$file;

        $form = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($form, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function getTempFile($id)
    {
        $file = eKenderaanAttachments::where('id', $id)->first();
        $filename = $file->upload;
        return Storage::response('eKenderaan/'.$filename);
    }

    public function cancelApplication($id)
    {
        $exist = eKenderaanAttachments::find($id);
        $exist->delete();

        return response()->json();
    }

    public function question()
    {
        return view('eKenderaan.feedback-questions');
    }

    public function questionList()
    {
        $question = eKenderaanFeedbackQuestion::get();

        return datatables()::of($question)

            ->editColumn('status', function ($question) {
                if ($question->status == 'Y') {
                    return '<div style="color: green;"><b>Finalize</b></div>';
                } else {
                    return '<div style="color: red;"><b>Not Finalize</b></div>';
                }
            })

            ->addColumn('edit', function ($question) {
                if ($question->status == 'Y') {
                    return '';
                } else {
                    return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$question->id.'" data-question="'.$question->question.'" data-sequence="'.$question->sequence.'" data-status="'.$question->status.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
                }
            })

            ->rawColumns(['status','edit'])
            ->addIndexColumn()
            ->make(true);
    }

    public function addQuestion(Request $request)
    {
        $request->validate([
            'sequence' => 'unique:ekn_feedback_questions,sequence'
        ]);

        eKenderaanFeedbackQuestion::create([
            'question'  => $request->question,
            'sequence'  => $request->sequence,
            'status'    => $request->status,
            'created_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function editQuestion(Request $request)
    {
        $update = eKenderaanFeedbackQuestion::where('id', $request->id)->first();
        $update->update([
            'question'      => $request->question,
            'sequence'  => $request->sequence,
            'status'    => $request->status,
            'updated_by'=> Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function assignDriver($id)
    {
        $data  = eKenderaanAssignDriver::where('ekn_details_id', $id)->get();

        return datatables()::of($data)

        ->editColumn('driver', function ($data) {
            return $data->driverList->name;
        })

        ->editColumn('action', function ($data) {
            return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-assign-driver/'.$data->id.'"><i class="fal fa-trash"></i></button>';
        })

        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function assignNewDriver(Request $request)
    {
        $validated = $request->validate([
            'driver'   => 'required',
        ]);

        eKenderaanAssignDriver::create([
            'ekn_details_id'=> $request->id,
            'driver_id'     => $request->driver,
            'created_by'    => Auth::user()->id
        ]);

        $driver = eKenderaanDrivers::where('id', $request->driver)->first();

        $user = Staff::where('staff_id', $driver->staff_id)->first();
        $user_email = $user->staff_email;

        $details = eKenderaan::where('id', $request->id)->first();
        $passenger = eKenderaanPassengers::where('ekn_details_id', $request->id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $request->id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $request->id)->get();
        $assignDriver = eKenderaanAssignDriver::where('ekn_details_id', $request->id)->get();
        $driver_assign    = array_column($assignDriver->toArray(), 'driver_id');
        $drivers           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();


        $data = [
            'receivers'   => $user->staff_name,
            'emel'        => 'Untuk makluman, anda telah ditugaskan pada :-',
            'departDate'  => date(' d/m/Y ', strtotime($details->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($details->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($details->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($details->return_time)),
            'destination' => $details->destination,
            'waitingArea' => $waitingArea,
            'driver'      => $drivers,
            'purpose'     => $details->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $data, function ($message) use ($user_email) {
            $message->subject('EKENDERAAN: PERMOHONAN BAHARU');
            $message->from('operasi@intec.edu.my');
            $message->to($user_email);
        });

        $staff = User::where('id', $details->intec_id)->first();
        $staff_email =  $staff->email;

        $data2 = [
            'receivers'   => $staff->name,
            'emel'        => 'Untuk makluman, terdapat perubahan pemandu bagi permohonan yang telah diluluskan. Berikut merupakan butiran permohonan:-',
            'departDate'  => date(' d/m/Y ', strtotime($details->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($details->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($details->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($details->return_time)),
            'destination' => $details->destination,
            'waitingArea' => $waitingArea,
            'driver'      => $drivers,
            'purpose'     => $details->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $data2, function ($message2) use ($staff_email) {
            $message2->subject('EKENDERAAN: PERUBAHAN PEMANDU');
            $message2->from('operasi@intec.edu.my');
            $message2->to($staff_email);
        });

        return redirect()->back()->with('message', 'Successfully Assigned New Driver!');
    }

    public function deleteAssignedDriver($id)
    {
        $data = eKenderaanAssignDriver::where('id', $id)->first();
        $driver = eKenderaanDrivers::where('id', $data->driver_id)->first();

        $user = Staff::where('staff_id', $driver->staff_id)->first();
        $user_email = $user->staff_email;

        $details = eKenderaan::where('id', $data->ekn_details_id)->first();
        $passenger = eKenderaanPassengers::where('ekn_details_id', $data->ekn_details_id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $data->ekn_details_id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $data->ekn_details_id)->get();
        $assignDriver = eKenderaanAssignDriver::where('ekn_details_id', $data->ekn_details_id)->get();
        $driver_assign    = array_column($assignDriver->toArray(), 'driver_id');
        $drivers           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();

        $exist = eKenderaanAssignDriver::find($id);
        $exist->delete();

        $datas = [
            'receivers'   => $user->staff_name,
            'emel'        => 'Untuk makluman, penugasan pada butiran tersebut telah dibatalkan.',
            'departDate'  => date(' d/m/Y ', strtotime($details->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($details->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($details->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($details->return_time)),
            'destination' => $details->destination,
            'waitingArea' => $waitingArea,
            'driver'      => $drivers,
            'purpose'     => $details->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $datas, function ($message) use ($user_email) {
            $message->subject('EKENDERAAN: PEMBATALAN TUGASAN');
            $message->from('operasi@intec.edu.my');
            $message->to($user_email);
        });


        return response()->json();
    }

    public function assignVehicle($id)
    {
        $vehicle  = eKenderaanAssignVehicle::where('ekn_details_id', $id)->get();

        return datatables()::of($vehicle)

        ->editColumn('vehicle', function ($vehicle) {
            return ''.$vehicle->vehicleList->name.' - '.$vehicle->vehicleList->plate_no.'';
        })

        ->editColumn('action', function ($vehicle) {
            return '<a href="#" data-target="#editVehicle" data-toggle="modal" data-id="'.$vehicle->id.'" data-vehicle="'.$vehicle->vehicle_id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-assign-vehicle/'.$vehicle->id.'"><i class="fal fa-trash"></i></button>';
        })

        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function assignNewVehicle(Request $request)
    {
        $validated = $request->validate([
            'vehicle'  => 'required',
        ]);

        eKenderaanAssignVehicle::create([
            'ekn_details_id' => $request->id,
            'vehicle_id'     => $request->vehicle,
            'created_by'     => Auth::user()->id
        ]);

        $detail = eKenderaan::where('id', $request->id)->first();
        $passenger = eKenderaanPassengers::where('ekn_details_id', $request->id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $request->id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $request->id)->get();

        $details = eKenderaanAssignDriver::where('ekn_details_id', $request->id)->get();
        $driver_assign    = array_column($details->toArray(), 'driver_id');
        $drivers           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();

        foreach ($drivers as $d) {
            $user_email = $d->driverDetails->staff_email;

            $data1 = [
                'receivers'   => $d->driverDetails->staff_name,
                'emel'        => 'Untuk makluman, terdapat perubahan kenderaan bagi permohonan berikut :-',
                'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
                'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
                'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
                'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
                'destination' => $detail->destination,
                'driver'      => $drivers,
                'waitingArea' => $waitingArea,
                'purpose'     => $detail->purpose,
                'passenger'   => $passenger,
                'vehicle'     => $vehicle,
                'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
            ];

            Mail::send('eKenderaan.email', $data1, function ($message) use ($user_email) {
                $message->subject('EKENDERAAN: PERUBAHAN KENDERAAN');
                $message->from('operasi@intec.edu.my');
                $message->to($user_email);
            });
        }

        $staff = User::where('id', $detail->intec_id)->first();
        $staff_email =  $staff->email;

        $data2 = [
            'receivers'   => $staff->name,
            'emel'        => 'Untuk makluman, terdapat perubahan kenderaan bagi permohonan yang telah diluluskan. Berikut merupakan butiran permohonan:-',
            'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
            'destination' => $detail->destination,
            'driver'      => $drivers,
            'waitingArea' => $waitingArea,
            'purpose'     => $detail->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $data2, function ($message2) use ($staff_email) {
            $message2->subject('EKENDERAAN: PERUBAHAN KENDERAAN');
            $message2->from('operasi@intec.edu.my');
            $message2->to($staff_email);
        });

        return redirect()->back()->with('message', 'Successfully Assigned New Vehicle!');
    }


    public function deleteAssignedVehicle($id)
    {
        $exist = eKenderaanAssignVehicle::find($id);
        $exist->delete();

        return response()->json();
    }

    public function updateAssignedVehicle(Request $request)
    {
        $data = eKenderaanAssignVehicle::where('id', $request->id)->first();
        $data->update([
            'vehicle_id' => $request->vehicle,
            'updated_by' => Auth::user()->id
        ]);


        $detail = eKenderaan::where('id', $data->ekn_details_id)->first();
        $passenger = eKenderaanPassengers::where('ekn_details_id', $data->ekn_details_id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $data->ekn_details_id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $data->ekn_details_id)->get();

        $details = eKenderaanAssignDriver::where('ekn_details_id', $data->ekn_details_id)->get();
        $driver_assign    = array_column($details->toArray(), 'driver_id');
        $drivers           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();

        foreach ($drivers as $d) {
            $user_email = $d->driverDetails->staff_email;

            $data1 = [
                'receivers'   => $d->driverDetails->staff_name,
                'emel'        => 'Untuk makluman, terdapat perubahan kenderaan bagi permohonan berikut :-',
                'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
                'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
                'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
                'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
                'destination' => $detail->destination,
                'driver'      => $drivers,
                'waitingArea' => $waitingArea,
                'purpose'     => $detail->purpose,
                'passenger'   => $passenger,
                'vehicle'     => $vehicle,
                'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
            ];

            Mail::send('eKenderaan.email', $data1, function ($message) use ($user_email) {
                $message->subject('EKENDERAAN: PERUBAHAN KENDERAAN');
                $message->from('operasi@intec.edu.my');
                $message->to($user_email);
            });
        }

        $staff = User::where('id', $detail->intec_id)->first();
        $staff_email =  $staff->email;

        $data2 = [
            'receivers'   => $staff->name,
            'emel'        => 'Untuk makluman, terdapat perubahan kenderaan bagi permohonan yang telah diluluskan. Berikut merupakan butiran permohonan:-',
            'departDate'  => date(' d/m/Y ', strtotime($detail->depart_date)),
            'departTime'  => date(' h:i A ', strtotime($detail->depart_time)),
            'returnDate'  => date(' d/m/Y ', strtotime($detail->return_date)),
            'returnTime'  => date(' h:i A ', strtotime($detail->return_time)),
            'destination' => $detail->destination,
            'driver'      => $drivers,
            'waitingArea' => $waitingArea,
            'purpose'     => $detail->purpose,
            'passenger'   => $passenger,
            'vehicle'     => $vehicle,
            'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
        ];

        Mail::send('eKenderaan.email', $data2, function ($message2) use ($staff_email) {
            $message2->subject('EKENDERAAN: PERUBAHAN KENDERAAN');
            $message2->from('operasi@intec.edu.my');
            $message2->to($staff_email);
        });


        return redirect()->back()->with('message', 'Assigned Vehicle Update Successfully');
    }

    public function driverReportList()
    {
        return view('eKenderaan.driver-report-list');
    }

    public function getDriverReportList()
    {
        $data = eKenderaanDrivers::get();

        return datatables()::of($data)

        ->editColumn('name', function ($data) {
            $details = Staff::where('staff_id', $data->staff_id)->first();

            return isset($details->staff_name) ? $details->staff_name : 'N/A';
        })

        ->editColumn('staff_id', function ($data) {
            return $data->staff_id;
        })

        ->addColumn('view', function ($data) {
            $assign = eKenderaanAssignDriver::where('driver_id', $data->id)->where('rating', '!=', 'null');

            if ($assign->exists()) {
                return '<a href="/view-driver-report/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            } else {
                return '<span style="color:red;"><b>No Feedback</b></span>';
            }
        })

        ->addIndexColumn()
        ->rawColumns(['view'])
        ->make(true);
    }

    public function viewDriverReport($id)
    {
        $years = eKenderaanAssignDriver::orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })
        ->unique(); //year selection

        $year = '';
        $months = '';
        $month = '';

        $details = eKenderaanAssignDriver::where('driver_id', $id)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $id = $driver->driver_id;
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->get();
        return view('eKenderaan.driver-report-view', compact('years', 'details', 'question', 'countScale', 'driver', 'id', 'year', 'month', 'months'));
    }

    public function DriverReportPDF($id)
    {
        $details = eKenderaanAssignDriver::where('driver_id', $id)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->get();
        return view('eKenderaan.driver-report-pdf', compact('details', 'question', 'countScale', 'driver'));
    }

    public function viewDriverReportYear($year, $id)
    {
        $years = eKenderaanAssignDriver::orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })
        ->unique(); //year selection

        $months = eKenderaanAssignDriver::whereYear('created_at', '=', $year)
        ->orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('F');
        })
        ->unique(); //month selection

        $month = '';

        $details = eKenderaanAssignDriver::where('driver_id', $id)->whereYear('created_at', '=', $year)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->whereYear('created_at', '=', $year)->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->whereYear('created_at', '=', $year)->get();

        return view('eKenderaan.driver-report-view', compact('id', 'years', 'details', 'question', 'countScale', 'driver', 'year', 'months', 'month'));
    }

    public function DriverReportPDFYear($year, $id)
    {
        $details = eKenderaanAssignDriver::where('driver_id', $id)->whereYear('created_at', '=', $year)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->whereYear('created_at', '=', $year)->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->whereYear('created_at', '=', $year)->get();
        return view('eKenderaan.driver-report-pdf', compact('details', 'question', 'countScale', 'driver'));
    }


    public function viewDriverReportYearMonth($year, $month, $id)
    {
        $years = eKenderaanAssignDriver::orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })
        ->unique(); //year selection

        $months = eKenderaanAssignDriver::whereYear('created_at', '=', $year)
        ->orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('F');
        })
        ->unique(); //month selection

        $monthConvert = date('m', strtotime($month));

        $details = eKenderaanAssignDriver::where('driver_id', $id)->whereMonth('created_at', '=', $monthConvert)->whereYear('created_at', '=', $year)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->whereMonth('created_at', '=', $monthConvert)
                    ->whereYear('created_at', '=', $year)->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->whereMonth('created_at', '=', $monthConvert)->whereYear('created_at', '=', $year)->get();

        return view('eKenderaan.driver-report-view', compact('id', 'years', 'details', 'question', 'countScale', 'driver', 'year', 'months', 'month'));
    }

    public function DriverReportPDFYearMonth($year, $month, $id)
    {
        $monthConvert = date('m', strtotime($month));

        $details = eKenderaanAssignDriver::where('driver_id', $id)->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $monthConvert)->get();
        $driver = eKenderaanAssignDriver::select('driver_id')->where('driver_id', $id)->first();
        $question = eKenderaanFeedbackService::select('ekn_feedback_questions_id')->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $monthConvert)->where('ekn_assigned_driver_id', $id)->groupBy('ekn_feedback_questions_id')->get();
        $countScale = eKenderaanFeedbackService::where('ekn_assigned_driver_id', $id)->whereYear('created_at', '=', $year)
                      ->whereMonth('created_at', '=', $monthConvert)->get();
        return view('eKenderaan.driver-report-pdf', compact('details', 'question', 'countScale', 'driver'));
    }

    public function operationCancelApplication(Request $request)
    {
        $user = Auth::user();

        $updateApplication = eKenderaan::where('id', $request->id)->first();
        $updateApplication->update([
            'status'     =>'6',
            'updated_by' => Auth::user()->id
        ]);

        eKenderaanLog::create([
            'ekn_details_id'  => $request->id,
            'name' => Auth::user()->name,
            'activity'  => 'Cancel Application',
            'created_by' => Auth::user()->id
        ]);

        $passenger = eKenderaanPassengers::where('ekn_details_id', $request->id)->get();
        $vehicle = eKenderaanAssignVehicle::where('ekn_details_id', $request->id)->get();
        $waitingArea = eKenderaanWaitingArea::where('ekn_details_id', $request->id)->get();

        $details = eKenderaanAssignDriver::where('ekn_details_id', $request->id)->get();
        $driver_assign    = array_column($details->toArray(), 'driver_id');
        $driver           = eKenderaanDrivers::whereIn('id', $driver_assign)->get();

        if (isset($driver)) {
            foreach ($driver as $d) {
                $user_email = $d->driverDetails->staff_email;

                $data = [
                    'receivers'   => $d->driverDetails->staff_name,
                    'emel'        => 'Untuk makluman, penugasan pada butiran tersebut telah dibatalkan.',
                    'departDate'  => date(' d/m/Y ', strtotime($updateApplication->depart_date)),
                    'departTime'  => date(' h:i A ', strtotime($updateApplication->depart_time)),
                    'returnDate'  => date(' d/m/Y ', strtotime($updateApplication->return_date)),
                    'returnTime'  => date(' h:i A ', strtotime($updateApplication->return_time)),
                    'destination' => $updateApplication->destination,
                    'driver'      => $driver,
                    'waitingArea' => $waitingArea,
                    'purpose'     => $updateApplication->purpose,
                    'passenger'   => $passenger,
                    'vehicle'     => $vehicle,
                    'footer'      => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256',
                ];

                Mail::send('eKenderaan.email', $data, function ($message) use ($user_email) {
                    $message->subject('EKENDERAAN: PEMBATALAN TUGASAN');
                    $message->from('operasi@intec.edu.my');
                    $message->to($user_email);
                });
            }
        }

        if (isset($details)) {
            foreach ($details as $d) {
                $d->delete();
                $d->update(['deleted_by' => Auth::user()->id]);
            }
        }

        $staff = User::where('id', $updateApplication->intec_id)->first();
        $staff_email =  $staff->email;

        $data = [
            'receivers' => $staff->name,
            'emel'      => 'Untuk makluman, permohonan anda untuk membatalkan permohonan e-Kenderaan telah dilaksanakan pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
            'footer'    => 'Sebarang pertanyaan atau perubahan, sila hubungi En. Ridzuan ditalian 017-3899256.',
        ];

        Mail::send('eKenderaan.email_announcement', $data, function ($message) use ($staff_email) {
            $message->subject('EKENDERAAN: PERMOHONAN DIBATALKAN');
            $message->from('operasi@intec.edu.my');
            $message->to($staff_email);
        });


        return response() ->json(['success' => 'Application Cancelled!']);
    }
}

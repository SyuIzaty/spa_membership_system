<?php

namespace App\Http\Controllers;

use App\User;
use DateTime;
use Carbon\Carbon;
use App\AduanKorporat;
use App\AduanKorporatLog;
use App\AduanKorporatFile;
use App\AduanKorporatUser;
use App\AduanKorporatAdmin;
use App\AduanKorporatRemark;
use App\AduanKorporatStatus;
use Illuminate\Http\Request;
use App\AduanKorporatCategory;
use App\AduanKorporatDepartment;
use App\AduanKorporatSubCategory;
use App\Exports\iComplaintExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Exports\iComplaintExportByYear;
use Illuminate\Support\Facades\Storage;
use App\Exports\iComplaintExportByYearMonth;

class AduanKorporatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function main()
    {
        return view('aduan-korporat.main');
    }

    public function index()
    {
        $category     = AduanKorporatCategory::all();
        $subcategory  = AduanKorporatSubCategory::all();
        $user         = Auth::user();
        return view('aduan-korporat.form', compact('category', 'subcategory', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_phone'   => 'required|regex:/[0-9]/|min:10|max:11',
            'category'     => 'required',
            'title'        => 'required',
            'description'  => 'required',
            'attachment.*' => 'required|file|mimes:jpeg,png,gif,pdf,doc,docx|max:2048',
        ], [
            'user_phone.min'        => 'Phone number does not match the format!',
            'user_phone.max'        => 'Phone number does not match the format!',
            'user_phone.regex'      => 'Phone number must be number only!',
            'user_phone.required'   => 'Phone number is required!',
            'attachment.*.required' => 'Attachment is required!',
            'attachment.*.file'     => 'Attachment must be a file!',
            'attachment.*.mimes'    => 'Attachment must be in image or document format (jpeg, png, gif, pdf, doc, docx)!',
            'attachment.*.max'      => 'Attachment size must not exceed 2MB!',
        ]);

        $data = AduanKorporat::create([
            'phone_no'      => $request->user_phone,
            'address'       => $request->address,
            'user_category' => $request->userCategory,
            'category'      => $request->category,
            'subcategory'   => $request->subcategory,
            'status'        => '1',
            'title'         => $request->title,
            'description'   => $request->description,
            'created_by'    => Auth::user()->id,
        ]);

        $cat = AduanKorporatCategory::where('id', $request->category)->first();
        $ticket = date('dmY').$cat->code.$data->id;

        AduanKorporat::where('id', $data->id)->update(['ticket_no' => $ticket]);

        AduanKorporatLog::create([
            'complaint_id'  => $data->id,
            'name'          => $request->user_name,
            'activity'      => 'Create new',
            'created_by'    => Auth::user()->id
        ]);

        $file = $request->attachment;

        if (isset($file)) {
            foreach ($file as $f => $value) {
                $originalName = $value->getClientOriginalName();
                $fileName = time() . '-' . $value->getClientOriginalName();
                Storage::disk('minio')->put("/iComplaint/" . $fileName, file_get_contents($value));
                AduanKorporatFile::create([
                    'complaint_id'  => $data->id,
                    'original_name' => $originalName,
                    'upload'        => $fileName,
                    'web_path'      => "iComplaint/" . $fileName,
                    'created_by'    => $request->user_id
                ]);
            }
        }

        // $admin = User::whereHas('roles', function ($query) {
        //     $query->where('id', 'EAK001'); // Admin
        // })->get();

        // foreach($admin as $a) {
        //     $admin_email = $a->email;

        //     $data = [
        //         'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $a->name,
        //         'emel'     => 'You have received new iComplaint from '.$request->user_name.' on '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Please log in to the IDS system for further action.',
        //     ];

        //     Mail::send('aduan-korporat.email', $data, function ($message) use ($admin_email) {
        //         $message->subject('New iComplaint');
        //         $message->from('corporate@intec.edu.my');
        //         $message->to($admin_email);
        //     });
        // }

        return redirect('end/'.$ticket);
    }

    public function end($ticket)
    {
        return view('aduan-korporat.end', compact('ticket'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function list($id)
    {
        $status = AduanKorporatStatus::where('id', $id)->first();
        return view('aduan-korporat.lists', compact('id', 'status'));
    }

    public function show($id)
    {
        if (Auth::user()->hasAnyRole('eAduan Super Admin', 'eAduan Admin')) {
            $list = AduanKorporat::where('status', $id)->orderby('created_at', 'DESC')->get();
        } else {
            $list = AduanKorporat::where('status', $id)->wherehas('getAdmin', function ($query) {
                $query->where('admin_id', Auth::user()->id);
            })->orderby('created_at', 'DESC')->get();
        }

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;
        })

        ->editColumn('complaint_date', function ($list) {

            return $list->created_at->format('d/m/Y');
        })

        ->editColumn('name', function ($list) {

            return $list->name;
        })

        ->editColumn('email', function ($list) {

            return $list->email;
        })

        ->editColumn('phone', function ($list) {

            return $list->phone_no;
        })

        ->editColumn('title', function ($list) {

            return $list->title;
        })

        ->editColumn('category', function ($list) {

            return $list->getCategory->description ?? '';
        })

        ->editColumn('subcategory', function ($list) {

            return $list->getSubCategory->description ?? 'N/A';
        })

        ->editColumn('user', function ($list) {

            return $list->getUserCategory->description ?? '';
        })

        ->editColumn('status', function ($list) {

            return $list->getStatus->description ?? '';
        })

        ->editColumn('assign', function ($list) {

            return isset($list->getDepartment->code) ? $list->getDepartment->code : 'N/A';
        })

        ->addColumn('action', function ($list) {

            return '<a href="/detail/' .$list->id.'" class="btn btn-sm btn-info"><i class="fal fa-eye"></i></a>
                    <a href="/log/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-list-alt"></i></a>';
        })

        ->addIndexColumn()

        ->rawColumns(['action'])
        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AduanKorporat  $aduanKorporat
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data = AduanKorporat::where('id', $id)->first();

        if($data->user_category == "STF" || $data->user_category == "STD") {
            $ids = $data->created_by;
        } else {
            $encrypted_id = $data->created_by;
            try {
                $ids = Crypt::decrypt($encrypted_id);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                $ids = $encrypted_id;
            }
        }
        $department = AduanKorporatDepartment::all();
        $dataRemark = AduanKorporatRemark::where('complaint_id', $id)->first();
        $file = AduanKorporatFile::where('complaint_id', $id)->get();
        $admin = AduanKorporatLog::where('complaint_id', $id)->where('activity', 'Completed')->first();

        return view('aduan-korporat.admin-view-detail', compact('data', 'department', 'dataRemark', 'file', 'admin', 'ids'));
    }

    //Start Assign Admin
    public function getDept(Request $request)
    {
        $message = $dept = '';

        if($request->department) {
            $department = AduanKorporatDepartment::where('id', $request->department)->first();

            $dept = $department->name;
        }

        $message = "Are you sure you want to assign ".$dept." department?";

        return response() ->json(['success' => $message]);
    }

    public function assign(Request $request)
    {
        if ($request->department) {
            $assign = AduanKorporat::where('id', $request->id)->first();
            $assign->update([
                'assign'     => $request->department,
                'status'     => '2',
                'updated_by' => Auth::user()->id
            ]);

            $user = User::where('id', Auth::user()->id)->first();

            AduanKorporatLog::create([
                'complaint_id'  => $request->id,
                'name'          => $user->name,
                'activity'      => 'Assign department',
                'created_by'    => Auth::user()->id
            ]);

            return response() ->json(['success' => 'Successful Assign!']);
        } else {
            return response() ->json(['success' => 'Please select department!']);
        }
    }

    //End Assign Admin


    //Start Admin Give Feedback

    public function remark(Request $request)
    {
        if ($request->remark) {
            $data  = new AduanKorporatRemark();
            $data->complaint_id = $request->id;
            $data->remark       = $request->remark;
            $data->created_by   = Auth::user()->id;
            $data->save();

            $update = AduanKorporat::where('id', $request->id)->first();
            $update->update([
                'status'     => '3',
                'updated_by' => Auth::user()->id
            ]);

            $user = User::where('id', Auth::user()->id)->first();

            AduanKorporatLog::create([
                'complaint_id'  => $request->id,
                'name'          => $user->name,
                'activity'      => 'Sent Feedback',
                'created_by'    => Auth::user()->id
            ]);

            $admin = User::whereHas('roles', function ($query) {
                $query->where('id', 'EAK001'); // Admin
            })->get();

            foreach($admin as $a) {
                $admin_email = $a->email;

                $data = [
                    'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $a->name,
                    'emel'     => 'Feedback for iComplaint ['.$update->ticket_no.'] has been made by '.$user->name.' on '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Please log in to the IDS system for further action.',
                ];

                Mail::send('aduan-korporat.email', $data, function ($message) use ($admin_email) {
                    $message->subject('iComplaint Feedback');
                    $message->from('corporate@intec.edu.my');
                    $message->to($admin_email);
                });
            }

            return response() ->json(['success' => 'Feedback sent!']);
        } else {
            return response() ->json(['success' => 'Please fill in feedback!']);
        }

    }

    public function complete(Request $request)
    {
        if ($request->adminremarks === null) {
            return response() ->json(['success' => 'Please fill in feedback!']);
        } else {
            $assign = AduanKorporatRemark::where('complaint_id', $request->id)->first();
            $assign->update([
                    'admin_remark' => $request->adminremarks,
                    'updated_by' => Auth::user()->id
                ]);

            $update = AduanKorporat::where('id', $request->id)->first();
            $update->update([
                'status'     => '4',
                'updated_by' => Auth::user()->id
            ]);

            $user = User::where('id', Auth::user()->id)->first();

            AduanKorporatLog::create([
                'complaint_id'  => $request->id,
                'name'          => $user->name,
                'activity'      => 'Completed',
                'created_by'    => Auth::user()->id
            ]);

            if ($request->check != '') {
                $user_email = $update->email;

                $data = [
                    'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $update->name,
                    'emel'     => 'You have received a feedback in iComplaint ['.$update->ticket_no.'] on '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Kindly check in: https://ids.intec.edu.my/iComplaint',
                ];

                Mail::send('aduan-korporat.email_user', $data, function ($message) use ($user_email) {
                    $message->subject('iComplaint Feedback');
                    $message->from('corporate@intec.edu.my');
                    $message->to($user_email);
                });
            }

            return response() ->json(['success' => 'Feedback successfully sent to user!']);
        }
    }

    //Start Change Assign Department
    public function changeDepartment(Request $request)
    {
        $update = AduanKorporat::where('id', $request->id)->first();
        $update->update([
            'assign'      => $request->department,
            'updated_by'  => Auth::user()->id
        ]);

        return response() ->json(['success' => 'Changes Saved!']);
    }
    //End Change Assign Department

    //End Admin Give Feedback

    public function file($id)
    {
        $file = AduanKorporatFile::where('id', $id)->first();
        return Storage::disk('minio')->response($file->web_path);
    }

    //Start Log List
    public function log($id)
    {
        return view('aduan-korporat.log', compact('id'));
    }

    public function logList($id)
    {
        $log = AduanKorporatLog::where('complaint_id', $id)->get();

        return datatables()::of($log)

            ->addColumn('ticket', function ($log) {
                return $log->complaint->first()->ticket_no ?? '';
            })

            ->addColumn('date', function ($log) {
                return $log->created_at->format('d/m/Y g:ia') ?? '';
            })

            ->addColumn('user', function ($log) {
                return $log->name ?? '';
            })

            ->rawColumns(['ticket','date','user'])
            ->make(true);
    }

    //End Log List

    public function publicList()
    {
        $userCategory = AduanKorporatUser::all();

        return view('aduan-korporat.public-list', compact('userCategory'));
    }

    public function getPublicList()
    {
        $list = AduanKorporat::where('created_by', Auth::user()->id)->get();

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;
        })

        ->editColumn('status', function ($list) {

            if ($list->status == '2' || $list->status == '3') {
                return "In Process";
            } else {
                return $list->getStatus->description;
            }
        })

        ->addColumn('action', function ($list) {
            return '<a href="/view-detail/' .$list->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addIndexColumn()

        ->rawColumns(['action'])
        ->make(true);
    }

    public function publicDetail($id)
    {
        $data = AduanKorporat::where('id', $id)->first();
        $user = Auth::user();
        $file = AduanKorporatFile::where('complaint_id', $id)->get();
        return view('aduan-korporat.view-detail', compact('data', 'file', 'user'));
    }

    //Start Dashboard
    public function dashboard()
    {
        $userCategory = AduanKorporatUser::select('code', 'description')->withCount('complaint')->orderBy('description', 'ASC')->get();

        $countUserCat[] = ['Category','Total'];
        foreach ($userCategory as $key => $value) {
            $countUserCat[++$key] = [$value->description, (int)$value->complaint_count];
        }

        $category = AduanKorporatCategory::select('id', 'description')->withCount('complaint')->orderBy('description', 'ASC')->get();

        $countCategory[] = ['Category','Total'];
        foreach ($category as $key => $value) {
            $countCategory[++$key] = [$value->description, (int)$value->complaint_count];
        }

        $subcategory = AduanKorporatSubCategory::select('id', 'description')->withCount('complaint')->orderBy('description', 'ASC')->get();

        $countSubCategory[] = ['Category','Total'];
        foreach ($subcategory as $key => $value) {
            $countSubCategory[++$key] = [$value->description, (int)$value->complaint_count];
        }

        $department = AduanKorporatDepartment::select('id', 'name')->withCount('complaint')->orderBy('name', 'ASC')->get();

        $countDepartment[] = ['Category','Total'];
        foreach ($department as $key => $value) {
            $countDepartment[++$key] = [ucwords(strtolower($value->name)), (int)$value->complaint_count];
        }

        $year = AduanKorporat::orderBy('created_at', 'ASC')
                ->pluck('created_at')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('Y');
                })
                ->unique(); //year selection

        return view('aduan-korporat.dashboard', compact('year'))->with('userCategory', json_encode($countUserCat))->with('category', json_encode($countCategory))->with('subcategory', json_encode($countSubCategory))->with('department', json_encode($countDepartment));
    }

    public function getDashboard(Request $request)
    {
        $month = date('m', strtotime($request->month));

        $userCategory = AduanKorporatUser::select('code', 'description')->withCount(['complaint' => function ($query) use ($month, $request) {
            $query->whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $month);
        }])->get();


        $countUserCat[] = ['Category','Total'];
        foreach ($userCategory as $key => $value) {
            $countUserCat[++$key] = [$value->description, (int)$value->complaint_count];
        }

        $category = AduanKorporatCategory::select('id', 'description')->withCount(['complaint' => function ($query) use ($month, $request) {
            $query->whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $month);
        }])->get();

        $countCategory[] = ['Category','Total'];
        foreach ($category as $key => $value) {
            $countCategory[++$key] = [$value->description, (int)$value->complaint_count];
        }

        $department = AduanKorporatDepartment::select('id', 'name')->withCount(['complaint' => function ($query) use ($month, $request) {
            $query->whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $month);
        }])->get();

        $countDepartment[] = ['Category','Total'];
        foreach ($department as $key => $value) {
            $countDepartment[++$key] = [ucwords(strtolower($value->name)), (int)$value->complaint_count];
        }

        $result = array( 'countUserCat' => $countUserCat, 'countCat' => $countCategory, 'countDepartment' => $countDepartment);

        return response()->json($result);
    }
    //End Dashboard

    //Start Report
    public function searchYear($year)
    {
        $month = AduanKorporat::whereYear('created_at', '=', $year)
                ->orderBy('created_at', 'ASC')
                ->pluck('created_at')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('F');
                })
                ->unique(); //month selection

        return response()->json($month);
    }


    public function iComplaintReport()
    {
        return Excel::download(new iComplaintExport(), 'iComplaint Full Report.xlsx');
    }

    public function iComplaintReportYear($year)
    {
        return Excel::download(new iComplaintExportByYear($year), 'iComplaint Report '.$year.'.xlsx');
    }

    public function iComplaintReportYearMonth($year, $month)
    {
        return Excel::download(new iComplaintExportByYearMonth($year, $month), 'iComplaint Report '.$month.' '.$year.'.xlsx');
    }

    public function reports()
    {
        $year = AduanKorporat::orderBy('created_at', 'ASC')
        ->pluck('created_at')
        ->map(function ($date) {
            return Carbon::parse($date)->format('Y');
        })
        ->unique(); //year selection

        return view('aduan-korporat.report', compact('year'));
    }

    public function allReport()
    {

        $list = AduanKorporat::all();

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;
        })

        ->editColumn('date', function ($list) {

            $date = new DateTime($list->created_at);

            $date = $date->format('d-m-Y');

            return $date;
        })

        ->editColumn('category', function ($list) {

            return $list->getCategory->description ?? '';
        })

        ->editColumn('user', function ($list) {

            return $list->getUserCategory->description ?? '';
        })

        ->editColumn('status', function ($list) {

            return $list->getStatus->description ?? '';
        })

        ->editColumn('department', function ($list) {

            return isset($list->getDepartment->name) ? $list->getDepartment->name : 'N/A';
        })

        ->editColumn('complete', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');

            if ($date->exists()) {

                $date = new DateTime($date->first()->created_at);

                $d = $date->format('d-m-Y');

                return $d;
            } else {
                return "N/A";
            }
        })

        ->editColumn('duration', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');

            if ($date->exists()) {

                return $list->created_at->diffInDays($date->first()->created_at)." days";
            } else {
                return $list->created_at->diffInDays(Carbon::now())." days";
            }
        })

        ->addIndexColumn()
        ->make(true);
    }

    public function getYear($year)
    {
        $month = AduanKorporat::whereYear('created_at', '=', $year)
                ->orderBy('created_at', 'ASC')
                ->pluck('created_at')
                ->map(function ($date) {
                    return Carbon::parse($date)->format('F');
                })
                ->unique(); //month selection

        return response()->json($month);
    }

    public function getReportYear(Request $request)
    {
        $list = AduanKorporat::whereYear('created_at', '=', $request->year)->get();

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;
        })

        ->editColumn('date', function ($list) {

            $date = new DateTime($list->created_at);

            $date = $date->format('d-m-Y');

            return $date;
        })

        ->editColumn('category', function ($list) {

            return $list->getCategory->description ?? '';
        })

        ->editColumn('user', function ($list) {

            return $list->getUserCategory->description ?? '';
        })

        ->editColumn('status', function ($list) {

            return $list->getStatus->description ?? '';
        })

        ->editColumn('department', function ($list) {

            return isset($list->getDepartment->name) ? $list->getDepartment->name : 'N/A';
        })

        ->editColumn('complete', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');
            if ($date->exists()) {

                $date = new DateTime($date->first()->created_at);

                $d = $date->format('d-m-Y');

                return $d;
            } else {
                return "N/A";
            }
        })

        ->editColumn('duration', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');

            if ($date->exists()) {

                return Carbon::parse($list->created_at)->diffInDays($date->first()->created_at)." days";
            } else {
                return Carbon::parse($list->created_at)->diffInDays(Carbon::now()->toDateTimeString())." days";
            }
        })

        ->addIndexColumn()
        ->make(true);
    }


    public function getReport(Request $request)
    {
        $month = date('m', strtotime($request->month));

        $list = AduanKorporat::whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $month)->get();

        return datatables()::of($list)

        ->editColumn('ticket_no', function ($list) {

            return $list->ticket_no;
        })

        ->editColumn('date', function ($list) {

            $date = new DateTime($list->created_at);

            $date = $date->format('d-m-Y');

            return $date;
        })

        ->editColumn('category', function ($list) {

            return $list->getCategory->description ?? '';
        })

        ->editColumn('user', function ($list) {

            return $list->getUserCategory->description ?? '';
        })

        ->editColumn('status', function ($list) {

            return $list->getStatus->description ?? '';
        })

        ->editColumn('department', function ($list) {

            return isset($list->getDepartment->name) ? $list->getDepartment->name : 'N/A';
        })

        ->editColumn('complete', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');
            if ($date->exists()) {

                $date = new DateTime($date->first()->created_at);

                $d = $date->format('d-m-Y');

                return $d;
            } else {
                return "N/A";
            }
        })

        ->editColumn('duration', function ($list) {

            $date = AduanKorporatLog::where('complaint_id', $list->id)->where('activity', 'Completed');

            if ($date->exists()) {

                return Carbon::parse($list->created_at)->diffInDays($date->first()->created_at)." days";
            } else {
                return Carbon::parse($list->created_at)->diffInDays(Carbon::now()->toDateTimeString())." days";
            }
        })

        ->addIndexColumn()
        ->make(true);
    }
    //End Report

    //Start Department List
    public function admin()
    {
        return view('aduan-korporat.department-list');
    }

    public function departmentLists()
    {
        $department = AduanKorporatDepartment::all();

        return datatables()::of($department)

            ->editColumn('department', function ($department) {
                return $department->name;
            })

            ->editColumn('total', function ($department) {
                return AduanKorporatAdmin::where('department_id', $department->id)->count();
            })

            ->addColumn('update', function ($department) {

                return '<a href="/admin-list/'.$department->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['update'])
            ->make(true);
    }
    //End Department List

    //Start Admin List
    public function adminList($id)
    {
        $department = AduanKorporatDepartment::where('id', $id)->first();
        $mainAdmin =  User::orderBy('name', 'ASC')->where('category', 'STF')->get();
        $admin = AduanKorporatAdmin::where('department_id', $id)->get();

        return view('aduan-korporat.admin-list', compact('id', 'department', 'mainAdmin', 'admin'));
    }

    public function storeAdmin(Request $request)
    {
        $error = [];
        $message = '';

        foreach($request->admin as $key => $value) {
            if (AduanKorporatAdmin::where('department_id', $request->id)->where('admin_id', $value)->count() > 0) {
                $staff = User::where('id', $value)->first();
                $error[] = $staff->name;
            } else {
                AduanKorporatAdmin::create([
                    'admin_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);

                $user = User::find($value);

                if(!$user->hasRole('eAduan Team')) {
                    $user->assignRole('eAduan Team');
                }
            }
        }

        if($error) {
            $message = "[".implode(',', $error)."] already inserted";
        }

        if($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Admin Added!');
        }
    }

    public function deleteAdmin($id)
    {
        $exist = AduanKorporatAdmin::where('id', $id)->first();
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);

        $user = User::find($exist->admin_id);

        $user->removeRole('eAduan Team');

        return response()->json(['success' => 'Deleted!']);
    }
    //End Admin List

    public function status()
    {
        $status = AduanKorporatStatus::all();

        return view('aduan-korporat.status', compact('status'));
    }

    public function getStatus()
    {
        $status = AduanKorporatStatus::all();

        return datatables()::of($status)

            ->editColumn('edit', function ($status) {
                return $status->id;
            })

            ->editColumn('edit', function ($status) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$status->id.'" data-status="'.$status->description.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->editColumn('delete', function ($status) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-status/' . $status->id . '"><i class="fal fa-trash"></i></button>';
            })

            ->rawColumns(['edit','delete'])
            ->make(true);
    }

    public function addStatus(Request $request)
    {
        AduanKorporatStatus::create([
            'description' => $request->status,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function updateStatus(Request $request)
    {
        $update = AduanKorporatStatus::where('id', $request->id)->first();
        $update->update([
            'description' => $request->status,
            'updated_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function destroyStatus($id)
    {
        $exist = AduanKorporatStatus::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);
    }

    public function category()
    {
        $category = AduanKorporatCategory::all();

        return view('aduan-korporat.category', compact('category'));
    }

    public function getCategory()
    {
        $category = AduanKorporatCategory::all();

        return datatables()::of($category)

            ->editColumn('edit', function ($category) {
                return $category->id;
            })

            ->editColumn('edit', function ($category) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$category->id.'" data-category="'.$category->description.'" data-code="'.$category->code.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->editColumn('delete', function ($category) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-categories/' . $category->id . '"><i class="fal fa-trash"></i></button>';
            })

            ->rawColumns(['edit','delete'])
            ->make(true);
    }

    public function addCategory(Request $request)
    {
        AduanKorporatCategory::create([
            'description' => $request->category,
            'code'        => $request->code,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function updateCategory(Request $request)
    {
        $update = AduanKorporatCategory::where('id', $request->id)->first();
        $update->update([
            'description' => $request->category,
            'code'        => $request->code,
            'updated_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function destroyCategory($id)
    {
        $exist = AduanKorporatCategory::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);
    }

    public function userCategory()
    {
        $category = AduanKorporatUser::all();

        return view('aduan-korporat.user-category', compact('category'));
    }

    public function getUserCategory()
    {
        $category = AduanKorporatUser::all();

        return datatables()::of($category)

            ->editColumn('edit', function ($category) {
                return $category->id;
            })

            ->editColumn('edit', function ($category) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$category->id.'" data-category="'.$category->description.'" data-code="'.$category->code.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->editColumn('delete', function ($category) {
                return '<button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-usercategory/' . $category->id . '"><i class="fal fa-trash"></i></button>';
            })

            ->rawColumns(['edit','delete'])
            ->make(true);
    }

    public function addUserCategory(Request $request)
    {
        AduanKorporatUser::create([
            'description' => $request->category,
            'code'        => $request->code,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function updateUserCategory(Request $request)
    {
        $update = AduanKorporatUser::where('id', $request->id)->first();
        $update->update([
            'description' => $request->category,
            'code'        => $request->code,
            'updated_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function destroyUserCategory($id)
    {
        $exist = AduanKorporatUser::find($id);
        $exist->delete();
        $exist->update(['deleted_by' => Auth::user()->id]);
    }

    public function subCategory()
    {
        return view('aduan-korporat.subcategory');
    }

    public function getSubCat()
    {
        $subcategory = AduanKorporatSubCategory::all();

        return datatables()::of($subcategory)

            ->addColumn('title', function ($subcategory) {
                return $subcategory->description;
            })

            ->editColumn('status', function ($subcategory) {

                if ($subcategory->active == '1') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('action', function ($subcategory) {
                return '<a href="#" data-target="#edit" data-toggle="modal" data-id="'.$subcategory->id.'" data-title="'.$subcategory->description.'" data-status="'.$subcategory->active.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['status','action'])
            ->make(true);
    }

    public function addSubCategory(Request $request)
    {
        AduanKorporatSubCategory::create([
            'description' => $request->description,
            'active'      => $request->active,
            'created_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
    }

    public function editSubCategory(Request $request)
    {
        $update = AduanKorporatSubCategory::where('id', $request->id)->first();
        $update->update([
            'description' => $request->title,
            'active'      => $request->status,
            'updated_by'  => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Update Successfully');
    }

}

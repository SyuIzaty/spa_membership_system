<?php

namespace App\Http\Controllers;

use File;
use Response;
use App\Staff;
use App\SopForm;
use App\SopList;
use App\SopOwner;
use App\SopDetail;
use Carbon\Carbon;
use App\SopFlowChart;
use App\SopDepartment;
use App\SopReviewRecord;
use App\SopCrossDepartment;
use Illuminate\Http\Request;
use App\Rules\CodeFormatRule;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;

class SOPController extends Controller
{
    public function index(Request $request)
    {
        $selectedDepartment = $request->department;

        $department         = SopDepartment::where('active', 'Y')->get();

        return view('sop.index', compact('department', 'selectedDepartment'));
    }

    public function getSOPList()
    {
        $owner = SopOwner::where('owner_id', Auth::user()->id)->first();

        if (Auth::user()->hasAnyRole(['SOP Admin'])) {

            $data = SopList::where('active', 'Y');

        } elseif (isset($owner)) {

            $data = SopList::where('department_id', $owner->department_id)->where('active', 'Y');
        }

        return datatables()::of($data)
            ->addColumn('sop', function ($data) {
                return isset($data->sop) ? ($data->sop) : 'N/A';
            })

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('cross_department', function ($data) {
                $all = '';

                $check = SopCrossDepartment::where('sop_list_id', $data->id);

                if ($check->exists()) {
                    foreach ($data->getCD as $c) {
                        $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>'.$c->crossDepartment->department_name.'</div>' : 'N/A';
                    }
                    return $all;
                } else {
                    return 'N/A';
                }
            })

            ->addColumn('owner', function ($data) {
                $owner = SopDetail::where('sop_lists_id', $data->id)->first();

                return isset($owner->prepare->staff_name) ? ($owner->prepare->staff_name) : 'N/A';
            })

            ->addColumn('status', function ($data) {
                if ($data->status == '1') {
                    return '<span style="color:red;"><b>'.$data->listStatus->name.'</b></span>';
                } elseif ($data->status == '2') {
                    return '<span style="color:green;"><b>'.$data->listStatus->name.'</b></span>';
                } else {
                    return '<span style="color:orange;"><b>'.$data->listStatus->name.'</b></span>';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            })

            ->addColumn('log', function ($data) {
                return '<a href="/sop/'.$data->id.'/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['status','action','log','cross_department'])
            ->make(true);
    }

    public function getSOPLists(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (department_id = '".$request->department."')";
        }

        $data = SopList::whereRaw($cond)->where('active', 'Y');

        return datatables()::of($data)

        ->addColumn('sop', function ($data) {
            return isset($data->sop) ? ($data->sop) : 'N/A';
        })

        ->addColumn('department', function ($data) {
            return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
        })

        ->addColumn('cross_department', function ($data) {
            $all = '';

            $check = SopCrossDepartment::where('sop_list_id', $data->id);

            if ($check->exists()) {
                foreach ($data->getCD as $c) {
                    $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>'.$c->crossDepartment->department_name.'</div>' : 'N/A';
                }
                return $all;
            } else {
                return 'N/A';
            }
        })

        ->addColumn('owner', function ($data) {
            $owner = SopDetail::where('sop_lists_id', $data->id)->first();

            return isset($owner->prepare->staff_name) ? ($owner->prepare->staff_name) : 'N/A';
        })

        ->addColumn('status', function ($data) {
            if ($data->status == '1') {
                return '<span style="color:red;"><b>'.$data->listStatus->name.'</b></span>';
            } elseif ($data->status == '2') {
                return '<span style="color:green;"><b>'.$data->listStatus->name.'</b></span>';
            } else {
                return '<span style="color:orange;"><b>'.$data->listStatus->name.'</b></span>';
            }
        })

        ->addColumn('action', function ($data) {
            return '<a href="/sop/'.$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addColumn('log', function ($data) {
            return '<a href="/sop/'.$data->id.'/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['status','action','log','cross_department'])
        ->make(true);
    }

    public function SOPTitle(Request $request)
    {
        $selectedDepartment = $request->department;
        $department         = SopDepartment::where('active', 'Y')->get();

        return view('sop.sop-title', compact('department', 'selectedDepartment'));
    }

    public function getSOPTitle()
    {
        $data = SopList::all();

        return datatables()::of($data)
            ->addColumn('sop', function ($data) {
                return isset($data->sop) ? ($data->sop) : 'N/A';
            })

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('cross_department', function ($data) {
                $all = '';
                foreach ($data->getCD as $c) {
                    $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>'.$c->crossDepartment->department_name.'</div>' : 'N/A';
                }
                return $all;
            })

            ->addColumn('status', function ($data) {
                if ($data->active == 'Y') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('action', function ($data) {

                $crossDept = SopCrossDepartment::where('sop_list_id', $data->id)->get();

                return '<a href="#" data-target="#edit" data-toggle="modal"
                data-id="'.$data->id.'" data-department="'.$data->department_id.'"
                data-title="'.$data->sop.'" data-status="'.$data->active.'" data-crossDept="'.$crossDept.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['action','status','cross_department'])
            ->make(true);
    }

    public function getSOPTitles(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (department_id = '".$request->department."')";
        }

        $data = SopList::whereRaw($cond);

        return datatables()::of($data)
        ->addColumn('sop', function ($data) {
            return isset($data->sop) ? ($data->sop) : 'N/A';
        })

        ->addColumn('department', function ($data) {
            return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
        })

        ->addColumn('cross_department', function ($data) {
            $all = '';
            foreach ($data->getCD as $c) {
                $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>'.$c->crossDepartment->department_name.'</div>' : 'N/A';
            }
            return $all;
        })

        ->addColumn('status', function ($data) {
            if ($data->active == 'Y') {
                return '<div style="color: green;"><b>Active</b></div>';
            } else {
                return '<div style="color: red;"><b>Inactive</b></div>';
            }
        })

        ->addColumn('action', function ($data) {
            return '<a href="#" data-target="#edit" data-toggle="modal"
            data-id="'.$data->id.'" data-department="'.$data->department_id.'"
            data-title="'.$data->sop.'" data-status="'.$data->active.'"
            class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action','status','cross_department'])
        ->make(true);
    }

    // public function add(Request $request)
    // {
    //     (new FastExcel())->import(request()->file('import_file'), function ($line) {
    //         return SopList::create([
    //             'sop' => $line['SOP'],
    //             'department_id' => $line['Dept'],
    //             'active' => $line['Active'],
    //             'created_by'    => Auth::user()->id
    //         ]);
    //     });

    //     return redirect()->back()->with('message', 'Add Successfully');
    // }

    public function addSOPTitle(Request $request)
    {
        $sop = SopList::create([
            'sop'           => $request->title,
            'department_id' => $request->department,
            'active'        => $request->status,
            'status'        => '1',
            'created_by'    => Auth::user()->id
        ]);

        if ($request->crossdept) {
            foreach($request->crossdept as $key => $value) {
                SopCrossDepartment::create([
                    'sop_list_id'   => $sop->id,
                    'dept_id'       => $request->department,
                    'cross_dept_id' => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);
            }
        }

        return redirect()->back()->with('message', 'Successfully Added!');
    }

    public function editSOPTitle(Request $request)
    {
        $update = SopList::where('id', $request->id)->first();
        $update->update([
            'sop'           => $request->title,
            'department_id' => $request->department,
            'active'        => $request->status,
            'updated_by'    => Auth::user()->id
        ]);

        if ($request->crossdept) {

            $crossDept = SopCrossDepartment::where('sop_list_id', $request->id)->get();

            // foreach ($crossDept as $cd) {
            //     foreach($request->crossdept as $key => $value) {
            //         if ($cd->cross_dept_id !=  $value) {
            //             $cd->delete();

            //             SopCrossDepartment::create([
            //                 'sop_list_id'   => $request->id,
            //                 'dept_id'       => $request->department,
            //                 'cross_dept_id' => $value,
            //                 'department_id' => $request->id,
            //                 'created_by'    => Auth::user()->id,
            //                 'updated_by'    => Auth::user()->id
            //             ]);
            //         }
            //     }
            // }

            foreach($request->crossdept as $key => $value) {
                if (SopCrossDepartment::where('sop_list_id', $request->id)->where('cross_dept_id', $value)->exists()) {
                    $data = SopCrossDepartment::where('sop_list_id', $request->id)->where('cross_dept_id', $value)->first();
                    $data->update([
                        'updated_by'    => Auth::user()->id
                    ]);
                } else {
                    SopCrossDepartment::create([
                        'sop_list_id'   => $request->id,
                        'dept_id'       => $request->department,
                        'cross_dept_id' => $value,
                        'department_id' => $request->id,
                        'created_by'    => Auth::user()->id,
                        // 'updated_by'    => Auth::user()->id
                    ]);
                }

                foreach ($crossDept as $cd) {
                    if ($cd->cross_dept_id !=  $value) {
                        $cd->delete();
                    }
                }
            }

        }

        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function SOPDepartment(Request $request)
    {
        $selectedDepartment = $request->department;
        $department         = SopDepartment::where('active', 'Y')->get();

        return view('sop.sop-department', compact('department', 'selectedDepartment'));
    }


    public function getSOPDepartment()
    {
        $data = SopDepartment::all();

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department_name) ? ($data->department_name) : 'N/A';
            })

            ->addColumn('abbreviation', function ($data) {
                return isset($data->abbreviation) ? ($data->abbreviation) : 'N/A';
            })

            ->addColumn('status', function ($data) {
                if ($data->active == 'Y') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="#" data-target="#edit" data-toggle="modal"
                data-id="'.$data->id.'" data-department="'.$data->department_name.'"
                data-abbreviation="'.$data->abbreviation.'" data-status="'.$data->active.'"
                class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function getSOPDepartments(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (id = '".$request->department."')";
        }

        $data = SopDepartment::whereRaw($cond);

        return datatables()::of($data)

        ->addColumn('department', function ($data) {
            return isset($data->department_name) ? ($data->department_name) : 'N/A';
        })

        ->addColumn('abbreviation', function ($data) {
            return isset($data->abbreviation) ? ($data->abbreviation) : 'N/A';
        })

        ->addColumn('status', function ($data) {
            if ($data->active == 'Y') {
                return '<div style="color: green;"><b>Active</b></div>';
            } else {
                return '<div style="color: red;"><b>Inactive</b></div>';
            }
        })

        ->addColumn('action', function ($data) {
            return '<a href="#" data-target="#edit" data-toggle="modal"
            data-id="'.$data->id.'"
            data-abbreviation="'.$data->abbreviation.'" data-status="'.$data->active.'"
            class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function addSOPDepartment(Request $request)
    {
        SopDepartment::create([
            'department_name' => $request->department,
            'abbreviation'   => $request->abbreviation,
            'active'         => $request->status,
            'created_by'     => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Added!');
    }

    public function editSOPDepartment(Request $request)
    {
        $update = SopDepartment::where('id', $request->id)->first();
        $update->update([
            'department_name' => $request->department,
            'abbreviation'   => $request->abbreviation,
            'active'         => $request->status,
            'updated_by'     => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function owner(Request $request)
    {
        $selectedDepartment = $request->department;
        $department         = SopDepartment::where('active', 'Y')->get();

        return view('sop.sop-owner', compact('department', 'selectedDepartment'));
    }

    public function getSOPOwner()
    {
        $data = SopDepartment::all();

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department_name) ? ($data->department_name) : 'N/A';
            })

            ->addColumn('owner', function ($data) {
                $all = '';

                $check = SopOwner::where('department_id', $data->id);

                if ($check->exists()) {
                    $owner = SopOwner::where('department_id', $data->id)->get();
                    foreach ($owner as $o) {
                        $all .= isset($o->staff->staff_name) ? '<div word-break: break-all;>'.$o->staff->staff_name.'</div>' : 'N/A';
                    }
                    return $all;
                } else {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop-owner/'.$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['owner','action'])
            ->make(true);
    }

    public function getSOPOwners(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (id = '".$request->department."')";
        }

        $data = SopDepartment::whereRaw($cond);

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department_name) ? ($data->department_name) : 'N/A';
            })

            ->addColumn('owner', function ($data) {
                $all = '';

                $check = SopOwner::where('department_id', $data->id);

                if ($check->exists()) {
                    $owner = SopOwner::where('department_id', $data->id)->get();
                    foreach ($owner as $o) {
                        $all .= isset($o->staff->staff_name) ? '<div word-break: break-all;>'.$o->staff->staff_name.'</div>' : 'N/A';
                    }
                    return $all;
                } else {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop-owner/'.$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['owner','action'])
            ->make(true);
    }

    public function viewOwner($id)
    {
        $staff      = Staff::all();
        $owner      = SopOwner::where('department_id', $id)->get();
        $department = SopDepartment::where('id', $id)->first();
        return view('sop.sop-owner-detail', compact('staff', 'owner', 'id', 'department'));
    }

    public function storeSOPOwner(Request $request)
    {
        $error = [];
        $message = '';

        foreach($request->owner as $key => $value) {
            if (SopOwner::where('department_id', $request->id)->where('owner_id', $value)->count() > 0) {
                $staff = Staff::where('staff_id', $value)->first();
                $error[] = $staff->staff_name;
            } else {
                SopOwner::create([
                    'owner_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id
                ]);
            }
        }

        if($error) {
            $message = "[".implode(',', $error)."] already inserted";
        }

        if($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Owner Added!');
        }
    }

    public function deleteSOPOwner($id)
    {
        $findOwner = SopOwner::find($id);
        $findOwner->delete();

        return response()->json(['success' => 'Deleted!']);
    }

    public function show($id)
    {
        $data       = SopList::where('id', $id)->first();
        $dateNow    = date(' j F Y ', strtotime(Carbon::now()->toDateTimeString()));
        $staff      = Staff::get();
        $department = SopDepartment::get();
        $sop        = SopDetail::where('sop_lists_id', $id)->first();
        $sopReview  = SopReviewRecord::where('sop_lists_id', $id)->get();
        $sopForm    = SopForm::where('sop_lists_id', $id)->get();
        $workFlow   = SopFlowChart::where('sop_lists_id', $id)->first();

        return view('sop.sop-main', compact('data', 'dateNow', 'staff', 'id', 'department', 'sop', 'sopReview', 'sopForm', 'workFlow'));
    }

    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                new CodeFormatRule(),
            ],
            'prepared_by' => 'required',
            'reviewed_by' => 'required',
            'approved_by' => 'required',
            'purpose'     => 'required',
            'scope'       => 'required',
            'procedure'   => 'required',
        ]);

        $data    = SopList::where('id', $request->id)->first();
        SopDetail::create([
            'sop_lists_id' => $request->id,
            'sop_dept_id'  => $data->department_id,
            'sop_code'     => $request->code,
            'prepared_by'  => $request->prepared_by,
            'reviewed_by'  => $request->reviewed_by,
            'approved_by'  => $request->approved_by,
            'purpose'      => $request->purpose,
            'scope'        => $request->scope,
            'reference'    => $request->reference,
            'definition'   => $request->definition,
            'procedure'    => $request->procedure,
            'created_by'   => Auth::user()->id
        ]);

        $sopList = SopList::where('id', $request->id)->first();

        $sopList->update([
            'status'       => '2',
        ]);

        return redirect()->back()->with('message', 'Successfully Saved!');
    }

    public function updateDetails(Request $request)
    {
        $update = SopDetail::where('sop_lists_id', $request->id)->first();

        // $originalApprovedBy = $update->approved_by;
        // $originalReviewedBy = $update->reviewed_by;
        // $originalPreparedBy = $update->prepared_by;
        // $originalSopCode    = $update->sop_code;
        // $originalPurpose    = $update->purpose;
        // $originalProcedure  = $update->procedure;
        // $originalScope      = $update->scope;
        // $originalReference  = $update->reference;
        // $originalDefinition = $update->definition;

        $update->update([
            'sop_code'     => $request->code,
            'prepared_by'  => $request->prepared_by,
            'reviewed_by'  => $request->reviewed_by,
            'approved_by'  => $request->approved_by,
            'purpose'      => $request->purpose,
            'scope'        => $request->scope,
            'reference'    => $request->reference,
            'definition'   => $request->definition,
            'procedure'    => $request->procedure,
            'updated_by'   => Auth::user()->id
        ]);

        // SOP Code, Prepared By, Reviewed By, Approved By, Purpose, Scope, Reference, Definition, Procedure
        if ($update->wasChanged('sop_code')) {
            $reviewRecord = 'Made an amendment on the SOP Code';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'SOP Code',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('prepared_by')) {

            // $nameOri = Staff::where('staff_id', $originalPreparedBy)->first();
            // $nameNew = Staff::where('staff_id', $request->prepared_by)->first();

            $reviewRecord = 'Made an amendment on the name of Prepared By';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Prepared By',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('reviewed_by')) {

            // $nameOri = Staff::where('staff_id', $originalReviewedBy)->first();
            // $nameNew = Staff::where('staff_id', $request->reviewed_by)->first();

            $reviewRecord = 'Made an amendment on the name of Reviewed By';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Reviewed By',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('approved_by')) {

            // $nameOri = Staff::where('staff_id', $originalApprovedBy)->first();
            // $nameNew = Staff::where('staff_id', $request->approved_by)->first();

            $reviewRecord = 'Made an amendment on the name of Approved By';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Approved By',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('purpose')) {
            $reviewRecord = 'Made an amendment on the Purpose';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Purpose',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('scope')) {
            $reviewRecord = 'Made an amendment on the Scope';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Scope',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('reference')) {
            $reviewRecord = 'Made an amendment on the Reference';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Reference',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('definition')) {
            $reviewRecord = 'Made an amendment on the Definition';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Definition',
                'created_by'    => Auth::user()->id
            ]);
        }

        if ($update->wasChanged('procedure')) {
            $reviewRecord = 'Made an amendment on the Procedure';

            SopReviewRecord::create([
                'sop_lists_id'  => $request->id,
                'review_record' => $reviewRecord,
                'section'       => 'Procedure',
                'created_by'    => Auth::user()->id
            ]);
        }


        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function getSOPReference()
    {
        $file = "INTEC SOP QM - Application for PA (Sample) 2022.pdf";

        $path = storage_path().'/sop/'.$file;

        $form = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($form, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function getReviewRecord($id)
    {
        $sopReview  = SopReviewRecord::where('id', $id)->first();
        return view('sop.sop-review-record', compact('sopReview'));
    }

    // public function storeReviewRecord(Request $request)
    // {
    //     $request->validate([
    //         'details' => 'required',
    //     ]);

    //     foreach ($request->details as $key => $value) {
    //         SopReviewRecord::create([
    //             'sop_lists_id'   => $request->id,
    //             'review_record'  => $value,
    //             'created_by'     => Auth::user()->id
    //         ]);
    //     }
    //     return redirect()->back()->with('message', 'Successfully Saved!');
    // }

    public function storeFormRecord(Request $request)
    {
        $request->validate([
            'formCode' => 'required',
            'formDetail' => 'required',
        ]);

        foreach ($request->formCode as $key => $value) {
            SopForm::create([
                'sop_lists_id'   => $request->id,
                'sop_code'       => $value,
                'details'        => $request->formDetail[$key],
                'created_by'     => Auth::user()->id
            ]);
        }
        return redirect()->back()->with('message', 'Successfully Saved!');
    }

    public function storeWorkFlow(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $fileName = time().$file->getClientOriginalName();

            Storage::disk('minio')->put("/sop/".$fileName, file_get_contents($file));

            SopFlowChart::create([
                'sop_lists_id'  => $request->id,
                'upload'        => $fileName,
                'web_path'      => "sop/".$fileName,
                'created_by'    => Auth::user()->id
        ]);
        }
        return response()->json(['success' => $fileName]);
    }

    public function workFlowFile($id)
    {
        $file = SopFlowChart::where('id', $id)->first();
        $filename = $file->upload;
        return Storage::disk('minio')->response('sop/'.$filename);
    }

    public function storeNewWorkFlow(Request $request)
    {
        $exist = SopFlowChart::where('sop_lists_id', $request->id)->whereNull('deleted_at')->first();
        // dd($exist->id);
        $exist->delete();

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $reviewRecord = 'Flowchart changed by ' . $staff->staff_name;

        SopReviewRecord::create([
            'sop_lists_id'  => $request->id,
            'review_record' => $reviewRecord,
            'section'       => 'Flowchart',
            'created_by'    => Auth::user()->id
        ]);

        $file = $request->file('file');
        if (isset($file)) {
            $fileName = time().$file->getClientOriginalName();

            Storage::disk('minio')->put("/sop/".$fileName, file_get_contents($file));

            SopFlowChart::create([
                'sop_lists_id'  => $request->id,
                'upload'        => $fileName,
                'web_path'      => "sop/".$fileName,
                'created_by'    => Auth::user()->id
        ]);
        }
        return response()->json(['success' => $fileName]);
    }

    public function generatePDF($id)
    {
        $data       = SopList::where('id', $id)->first();
        $dateNow    = date(' j F Y ', strtotime(Carbon::now()->toDateTimeString()));
        $date       = Carbon::now();
        $staff      = Staff::get();
        $department = SopDepartment::get();
        $sop        = SopDetail::where('sop_lists_id', $id)->first();
        $sopReview  = SopReviewRecord::where('sop_lists_id', $id)->get();
        $sopForm    = SopForm::where('sop_lists_id', $id)->get();
        $workFlow   = SopFlowChart::where('sop_lists_id', $id)->first();

        return view('sop.sop-pdf', compact('data', 'dateNow', 'date', 'staff', 'id', 'department', 'sop', 'sopReview', 'sopForm', 'workFlow'));
    }
}

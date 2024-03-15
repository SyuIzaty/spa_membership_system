<?php

namespace App\Http\Controllers;

use App\User;
use App\Staff;
use App\SopForm;
use App\SopList;
use App\SopOwner;
use App\SopDetail;
use Carbon\Carbon;
use App\SopComment;
use App\SopFlowChart;
use App\SopDepartment;
use App\SopReviewRecord;
use App\SopCrossDepartment;
use Illuminate\Http\Request;
use App\Rules\CodeFormatRule;
use App\Rules\FormFormatRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('cross_department', function ($data) {
                $all = '';

                $check = SopCrossDepartment::where('sop_lists_id', $data->id);

                if ($check->exists()) {
                    $crossDepartments = $data->crossDepartment;

                    if (count($crossDepartments) >= 2) {
                        $all = '<ul>';
                        foreach ($crossDepartments as $c) {
                            $departmentName = isset($c->crossDepartment->department_name) ? $c->crossDepartment->department_name : 'N/A';
                            $all .= '<li>' . $departmentName . '</li>';
                        }
                        $all .= '</ul>';
                    } else {
                        $all = isset($crossDepartments[0]->crossDepartment->department_name) ? '<div>' . $crossDepartments[0]->crossDepartment->department_name . '</div>' : 'N/A';
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
                    return '<span style="color:red;"><b>' . $data->listStatus->name . '</b></span>';
                } elseif ($data->status == '2') {
                    return '<span style="color:green;"><b>' . $data->listStatus->name . '</b></span>';
                } elseif ($data->status == '3') {
                    return '<span style="color:orange;"><b>' . $data->listStatus->name . '</b></span>';
                } else {
                    return '<span style="color:blue;"><b>' . $data->listStatus->name . '</b></span>';
                }
            })

            ->addColumn('action', function ($data) {
                $detail = SopDetail::where('sop_lists_id', $data->id)->first();
                $user = Auth::user()->id;
                if (($data->status == '1' || $data->status == '2') && isset($detail->prepared_by)) {
                    if ($detail->prepared_by == $user) {
                        return '<div class="btn-group"><a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                            <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-sop-details/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                    } else {
                        return '<a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                    }
                } else {
                    return '<a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['status','action','cross_department'])
            ->make(true);
    }

    public function getSOPLists(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (department_id = '" . $request->department . "')";
        }

        $data = SopList::whereRaw($cond)->where('active', 'Y');

        return datatables()::of($data)

        ->addColumn('department', function ($data) {
            return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
        })

        ->addColumn('cross_department', function ($data) {
            $all = '';

            $check = SopCrossDepartment::where('sop_lists_id', $data->id);

            if ($check->exists()) {
                $crossDepartments = $data->crossDepartment;

                if (count($crossDepartments) >= 2) {
                    $all = '<ul>';
                    foreach ($crossDepartments as $c) {
                        $departmentName = isset($c->crossDepartment->department_name) ? $c->crossDepartment->department_name : 'N/A';
                        $all .= '<li>' . $departmentName . '</li>';
                    }
                    $all .= '</ul>';
                } else {
                    $all = isset($crossDepartments[0]->crossDepartment->department_name) ? '<div>' . $crossDepartments[0]->crossDepartment->department_name . '</div>' : 'N/A';
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
                return '<span style="color:red;"><b>' . $data->listStatus->name . '</b></span>';
            } elseif ($data->status == '2') {
                return '<span style="color:green;"><b>' . $data->listStatus->name . '</b></span>';
            } elseif ($data->status == '3') {
                return '<span style="color:orange;"><b>' . $data->listStatus->name . '</b></span>';
            } else {
                return '<span style="color:blue;"><b>' . $data->listStatus->name . '</b></span>';
            }
        })

        ->addColumn('action', function ($data) {
            $detail = SopDetail::where('sop_lists_id', $data->id)->first();
            $user = Auth::user()->id;
            if (($data->status == '1' || $data->status == '2') && isset($detail->prepared_by)) {
                if ($detail->prepared_by == $user) {
                    return '<div class="btn-group"><a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-sop-details/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } else {
                    return '<a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                }
            } else {
                return '<a href="/sop/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            }
        })

        ->addIndexColumn()
        ->rawColumns(['status','action','cross_department'])
        ->make(true);
    }

    public function SOPTitle(Request $request)
    {
        $selectedDepartment = $request->department;
        $department         = SopDepartment::where('active', 'Y')->get();
        $staff              = Staff::all();

        return view('sop.sop-title', compact('department', 'selectedDepartment', 'staff'));
    }

    public function getSOPTitle()
    {
        $data = SopList::with(['department','crossDepartment']);

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('cross_department', function ($data) {
                $all = '';

                $check = SopCrossDepartment::with(['department','crossDepartment'])->where('sop_lists_id', $data->id);

                if ($check->exists()) {
                    foreach ($data->crossDepartment as $c) {
                        $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>' . $c->crossDepartment->department_name . '</div>' : 'N/A';
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
                if ($data->active == 'Y') {
                    return '<div style="color: green;"><b>Active</b></div>';
                } else {
                    return '<div style="color: red;"><b>Inactive</b></div>';
                }
            })

            ->addColumn('action', function ($data) {
                $person = SopDetail::where('sop_lists_id', $data->id)->first();

                if (isset($person->prepared_by)) {
                    return '<button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="' . $data->id . '" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <a href="#" data-target="#editPrepare" data-toggle="modal" data-id="' . $person->id . '" data-prepared="' . $person->prepared_by . '" class="btn btn-sm btn-warning"><i class="fal fa-user"></i></a>';
                } else {
                    return '<button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="' . $data->id . '" id="edit" name="edit"><i class="fal fa-pencil"></i></button>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['action','status','cross_department'])
            ->make(true);
    }

    public function getSOPTitles(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (department_id = '" . $request->department . "')";
        }

        $data = SopList::with(['department','crossDepartment'])->whereRaw($cond);

        return datatables()::of($data)

        ->addColumn('department', function ($data) {
            return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
        })

        ->addColumn('cross_department', function ($data) {
            $all = '';

            $check = SopCrossDepartment::where('sop_lists_id', $data->id);

            if ($check->exists()) {
                foreach ($data->crossDepartment as $c) {
                    $all .= isset($c->crossDepartment->department_name) ? '<div word-break: break-all;>' . $c->crossDepartment->department_name . '</div>' : 'N/A';
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
            if ($data->active == 'Y') {
                return '<div style="color: green;"><b>Active</b></div>';
            } else {
                return '<div style="color: red;"><b>Inactive</b></div>';
            }
        })

        ->addColumn('action', function ($data) {
            $person = SopDetail::where('sop_lists_id', $data->id)->first();

            if (isset($person->prepared_by)) {
                return '<button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="' . $data->id . '" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                <a href="#" data-target="#editPrepare" data-toggle="modal" data-id="' . $person->id . '" data-prepared="' . $person->prepared_by . '" class="btn btn-sm btn-warning"><i class="fal fa-user"></i></a>';
            } else {
                return '<button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="' . $data->id . '" id="edit" name="edit"><i class="fal fa-pencil"></i></button>';
            }
        })

        ->addIndexColumn()
        ->rawColumns(['action','status','cross_department'])
        ->make(true);
    }

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
                    'sop_lists_id'  => $sop->id,
                    'cross_dept_id' => $value,
                    'created_by'    => Auth::user()->id,
                    'updated_by'    => Auth::user()->id
                ]);
            }
        }

        return redirect()->back()->with('message', 'Successfully Added!');
    }

    public function getSOPTitleID($id)
    {
        $sopList = SopList::find($id);
        echo json_encode($sopList);
    }

    public function getSOPTitleDept($id)
    {
        $crossDept  = SopCrossDepartment::where('sop_lists_id', $id)->get();
        $cd         = $crossDept->pluck('cross_dept_id')->toArray();
        $department = SopDepartment::where('active', 'Y')->get();
        $dept       = SopList::where('id', $id)->pluck('department_id')->toArray();

        return response()->json(compact('cd', 'department', 'dept'));
    }

    public function editSOPTitle(Request $request)
    {
        if (isset($request->crossdept)) {
            SopCrossDepartment::where('sop_lists_id', $request->id)
            ->whereNotIn('cross_dept_id', $request->crossdept)->delete();

            foreach($request->crossdept as $crossdepts) {
                SopCrossDepartment::firstOrCreate([
                    'sop_lists_id'  => $request->id,
                    'cross_dept_id' => $crossdepts,
                ]);
            }
        } else {
            SopCrossDepartment::where('sop_lists_id', $request->id)->delete();
        }

        $update = SopList::where('id', $request->id)->first();
        $update->update([
            'sop'           => $request->title,
            'department_id' => $request->department,
            'active'        => $request->status,
            'updated_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function editPreparedBy(Request $request)
    {
        $update = SopDetail::where('id', $request->id)->first();
        $update->update([
            'prepared_by' => $request->prepared,
            'updated_by'  => Auth::user()->id
        ]);

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
                data-id="' . $data->id . '" data-department="' . $data->department_name . '"
                data-abbreviation="' . $data->abbreviation . '" data-status="' . $data->active . '"
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
            $cond .= " AND (id = '" . $request->department . "')";
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
            data-id="' . $data->id . '"
            data-abbreviation="' . $data->abbreviation . '" data-status="' . $data->active . '"
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
            'abbreviation'    => $request->abbreviation,
            'active'          => $request->status,
            'created_by'      => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Successfully Added!');
    }

    public function editSOPDepartment(Request $request)
    {
        $update = SopDepartment::where('id', $request->id)->first();
        $update->update([
            'department_name' => $request->department,
            'abbreviation'    => $request->abbreviation,
            'active'          => $request->status,
            'updated_by'      => Auth::user()->id
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
                        $all .= isset($o->staff->staff_name) ? '<div word-break: break-all;>' . $o->staff->staff_name . '</div>' : 'N/A';
                    }
                    return $all;
                } else {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop-owner/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['owner','action'])
            ->make(true);
    }

    public function getSOPOwners(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (id = '" . $request->department . "')";
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
                        $all .= isset($o->staff->staff_name) ? '<div word-break: break-all;>' . $o->staff->staff_name . '</div>' : 'N/A';
                    }
                    return $all;
                } else {
                    return 'N/A';
                }
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop-owner/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
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
        $error   = [];
        $message = '';

        foreach($request->owner as $key => $value) {
            if (SopOwner::where('department_id', $request->id)->where('owner_id', $value)->count() > 0) {
                $staff   = Staff::where('staff_id', $value)->first();
                $error[] = $staff->staff_name;
            } else {
                SopOwner::create([
                    'owner_id'      => $value,
                    'department_id' => $request->id,
                    'created_by'    => Auth::user()->id
                ]);

                $user = User::find($value);

                if (!$user->hasRole('SOP Owner')) {
                    $user->assignRole('SOP Owner');
                }
            }
        }

        if($error) {
            $message = "[" . implode(',', $error) . "] already inserted";
        }

        if($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Owner Added!');
        }
    }

    public function deleteSOPOwner($id)
    {
        $owner = SopOwner::where('id', $id)->first();

        $user  = User::find($owner->owner_id);

        $user->removeRole('SOP Owner');

        $exist = SopOwner::find($id);
        $exist->update(['deleted_by' => Auth::user()->id]);
        $exist->delete();

        return response()->json(['success' => 'Deleted!']);
    }

    public function show($id)
    {
        $data       = SopList::where('id', $id)->first();
        $dateNow    = date(' j F Y ', strtotime(Carbon::now()->toDateTimeString()));
        $staff      = Staff::get();
        $department = SopDepartment::where('active', 'Y')->get();
        $sop        = SopDetail::where('sop_lists_id', $id)->first();
        $sopReview  = SopReviewRecord::where('sop_lists_id', $id)->get();
        $sopForm    = SopForm::where('sop_lists_id', $id)->get();
        $workFlow   = SopFlowChart::where('sop_lists_id', $id)->orderBy('web_path', 'ASC')->get();
        $comment    = SopComment::where('sop_lists_id', $id)->get();

        return view('sop.sop-main', compact('data', 'dateNow', 'staff', 'id', 'department', 'sop', 'sopReview', 'sopForm', 'workFlow', 'comment'));
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
            'definition'  => 'required',
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
            'purpose'      => preg_replace('/^<p>|<\/p>$/', '', $request->purpose),
            'scope'        => preg_replace('/^<p>|<\/p>$/', '', $request->scope),
            'reference'    => preg_replace('/^<p>|<\/p>$/', '', $request->reference),
            'definition'   => preg_replace('/^<p>|<\/p>$/', '', $request->definition),
            'procedure'    => preg_replace('/^<p>|<\/p>$/', '', $request->procedure),
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
            'definition'  => 'required',
            'procedure'   => 'required',
        ]);

        // dd($request->all(), $validated);

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
            'purpose'      => preg_replace('/^<p>|<\/p>$/', '', $request->purpose),
            'scope'        => preg_replace('/^<p>|<\/p>$/', '', $request->scope),
            'reference'    => preg_replace('/^<p>|<\/p>$/', '', $request->reference),
            'definition'   => preg_replace('/^<p>|<\/p>$/', '', $request->definition),
            'procedure'    => preg_replace('/^<p>|<\/p>$/', '', $request->procedure),
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
        $filename = "INTEC SOP QM - Application for PA (Sample) 2022.pdf";

        return Storage::disk('minio')->response('sop/reference/' . $filename);
    }

    public function storeFormRecord(Request $request)
    {
        $request->validate([
             'formCode.*' => [
                 'required',
                 new FormFormatRule(),
             ],
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

    public function updateFormRecord(Request $request)
    {
        $reviewRecord = 'Made an amendment on the Form';

        if ($request->ajax()) {
            if ($request->action == 'edit') {
                $validator = Validator::make($request->all(), [
                    'code' => [
                        'required',
                        new FormFormatRule(),
                    ],
                    'details' => 'required',
                ]);

                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return response()->json(['errors' => $errors]);
                } else {
                    $update = SopForm::where('id', $request->id)->first();
                    $update->update([
                        'sop_code'   => $request->code,
                        'details'    => $request->details,
                        'updated_by' => Auth::user()->id
                    ]);

                    SopReviewRecord::create([
                        'sop_lists_id'  => $update->sop_lists_id,
                        'review_record' => $reviewRecord,
                        'section'       => 'Form',
                        'created_by'    => Auth::user()->id
                    ]);

                    return response()->json($request);
                }
            }

            if ($request->action == 'delete') {

                $form = SopForm::where('id', $request->id)->first();

                SopReviewRecord::create([
                    'sop_lists_id'  => $form->sop_lists_id,
                    'review_record' => $reviewRecord,
                    'section'       => 'Form',
                    'created_by'    => Auth::user()->id
                ]);

                SopForm::find($request->id)->delete();

                return response()->json($request);
            }
        }
    }

    public function storeWorkFlow(Request $request)
    {
        $file = $request->file('file');

        if (isset($file)) {
            $fileName = time() . $file->getClientOriginalName();

            Storage::disk('minio')->put("/sop/" . $fileName, file_get_contents($file));

            SopFlowChart::create([
                'sop_lists_id'  => $request->id,
                'upload'        => $fileName,
                'web_path'      => "sop/" . $fileName,
                'created_by'    => Auth::user()->id
        ]);
        }

        return response()->json(['success' => $fileName]);
    }

    public function workFlowFile($id)
    {
        $file = SopFlowChart::where('id', $id)->first();
        $filename = $file->upload;

        return Storage::disk('minio')->response('sop/' . $filename);
    }

    public function storeNewWorkFlow(Request $request)
    {
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
            $fileName = time() . $file->getClientOriginalName();

            Storage::disk('minio')->put("/sop/" . $fileName, file_get_contents($file));

            SopFlowChart::create([
                'sop_lists_id'  => $request->id,
                'upload'        => $fileName,
                'web_path'      => "sop/" . $fileName,
                'created_by'    => Auth::user()->id
        ]);
        }

        return response()->json(['success' => $fileName]);
    }

    public function deleteWorkFlow($id)
    {
        $file = SopFlowChart::find($id);

        $attach = SopFlowChart::where('id', $id)->first();

        if(Storage::disk('minio')->exists($attach->web_path) == 'true') {
            Storage::disk('minio')->delete($attach->web_path);
        }

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $reviewRecord = 'Flowchart deleted by ' . $staff->staff_name;

        SopReviewRecord::create([
            'sop_lists_id'  => $attach->sop_lists_id,
            'review_record' => $reviewRecord,
            'section'       => 'Flowchart',
            'created_by'    => Auth::user()->id
        ]);

        $attach->delete();

        $file->delete();

        return response()->json(['success' => 'Deleted!']);
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
        $workFlow   = SopFlowChart::where('sop_lists_id', $id)->orderBy('web_path', 'ASC')->get();

        return view('sop.sop-pdf', compact('data', 'dateNow', 'date', 'staff', 'id', 'department', 'sop', 'sopReview', 'sopForm', 'workFlow'));
    }

    public function commentSOP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        SopComment::create([
            'sop_lists_id' => $request->id,
            'comment'      => $request->comment,
            'created_by'   => Auth::user()->id
        ]);

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        $reviewRecord = 'Leave comment(s)';

        SopReviewRecord::create([
            'sop_lists_id'  => $request->id,
            'review_record' => $reviewRecord,
            'section'       => 'Comment',
            'created_by'    => Auth::user()->id
        ]);

        $update = SopList::where('id', $request->id)->first();

        if ($update->status == '3') {
            $update->update([
                'status'     => '2',
                'updated_by' => Auth::user()->id
            ]);
        }

        $details = SopDetail::where('sop_lists_id', $request->id)->first();
        $staff   = Staff::where('staff_id', $details->prepared_by)->first();
        $email   =  $staff->staff_email;

        $data2 = [
            'receivers' => $staff->staff_name,
            'emel'      => 'You have received a comment from QAG Admin on ' . date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
            'footer'    => 'Please log in to the IDS system for further action.',
        ];

        Mail::send('sop.email-comment', $data2, function ($message2) use ($email) {
            $message2->subject('SOP: COMMENT');
            $message2->from('qac@intec.edu.my');
            $message2->to($email);
        });


        return response()->json(['success' => 'Submitted!']);
    }

    public function verifySOP($id)
    {
        $update = SopList::where('id', $id)->first();
        $update->update([
            'status'     => '3',
            'updated_by' => Auth::user()->id
        ]);

        return response()->json(['success' => 'Verified!']);
    }

    public function approveSOP($id)
    {
        $update = SopList::where('id', $id)->first();
        $update->update([
            'status'      => '4',
            'approved_at' => Carbon::now(),
            'updated_by'  => Auth::user()->id
        ]);

        return response()->json(['success' => 'Approved!']);
    }

    public function sopList(Request $request)
    {
        $selectedDepartment = $request->department;

        $department         = SopDepartment::where('active', 'Y')->get();

        return view('sop.sop-finalized', compact('department', 'selectedDepartment'));
    }

    public function fetchSOPList()
    {
        $data = SopList::where('status', '4')->where('active', 'Y');

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                return '<a style="color: white" data-page="/generate-PDF/' . $data->id . '" class="btn btn-info"
                onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>';
            })

            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function fetchSOPLists(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (department_id = '" . $request->department . "')";
        }

        $data = SopList::whereRaw($cond)->where('status', '4')->where('active', 'Y');

        return datatables()::of($data)

        ->addColumn('department', function ($data) {
            return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
        })

        ->addColumn('action', function ($data) {
            return '<a style="color: white" data-page="/generate-PDF/' . $data->id . '" class="btn btn-info"
            onclick="Print(this)"><i class="fal fa-download"></i> PDF</a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function deleteSOPDetails($id)
    {
        $detail = SopDetail::where('sop_lists_id', $id);

        if ($detail->exists()) {
            $details = $detail->first();

            $details->update([
                'deleted_by' => Auth::user()->id,
            ]);

            $details->delete();
        }

        $form = SopForm::where('sop_lists_id', $id);

        if ($form->exists()) {

            $forms = SopForm::where('sop_lists_id', $id)->get();

            foreach ($forms as $f) {
                $f->update([
                    'deleted_by' => Auth::user()->id,
                ]);

                $f->delete();
            }
        }

        $workFlow = SopFlowChart::where('sop_lists_id', $id);

        if ($workFlow->exists()) {

            $workFlows = SopFlowChart::where('sop_lists_id', $id)->get();

            foreach ($workFlows as $w) {

                if (Storage::disk('minio')->exists($w->web_path) == 'true') {
                    Storage::disk('minio')->delete($w->web_path);
                }

                $w->update([
                    'deleted_by' => Auth::user()->id,
                ]);

                $w->delete();
            }
        }

        $record = SopReviewRecord::where('sop_lists_id', $id);

        if ($record->exists()) {

            $records = SopReviewRecord::where('sop_lists_id', $id)->get();

            foreach ($records as $r) {
                $r->update([
                    'deleted_by' => Auth::user()->id,
                ]);

                $r->delete();
            }
        }

        $comment = SopComment::where('sop_lists_id', $id);

        if ($comment->exists()) {

            $comments = SopComment::where('sop_lists_id', $id)->get();

            foreach ($comments as $c) {
                $c->update([
                    'deleted_by' => Auth::user()->id,
                ]);

                $c->delete();
            }
        }

        $sop = SopList::where('id', $id)->first();

        //reset SOP
        $sop->update([
            'status'     => '1',
            'updated_by' => Auth::user()->id
            ]);

        return response()->json();
    }
}

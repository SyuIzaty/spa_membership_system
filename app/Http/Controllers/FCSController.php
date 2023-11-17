<?php

namespace App\Http\Controllers;

use App\FcsLog;
use App\User;
use App\Staff;
use App\FcsMain;
use App\FcsOwner;
use App\FcsMainSub;
use App\SopDepartment;
use App\FcsMainSubActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FCSController extends Controller
{
    public function index(Request $request)
    {
        $selectedDepartment = $request->department;
        $department         = SopDepartment::where('active', 'Y')->get();
        $owner              = FcsOwner::where('staff_id', Auth::user()->id)->first();

        return view('file-classification.index', compact('department', 'selectedDepartment', 'owner'));
    }

    public function fileMainList()
    {
        $owner = FcsOwner::where('staff_id', Auth::user()->id)->first();

        if (Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {

            $data = FcsMain::with('department');

        } elseif (isset($owner)) {

            $data = FcsMain::with('department')->where('dept_id', $owner->dept_id);
        }

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

                if (isset($owner)) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';

                } else {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                }
            })

            ->addColumn('log', function ($data) {
                return '<a href="/log-file-classification/' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action','log'])
            ->make(true);
    }

    public function fileMainLists(Request $request)
    {
        $cond = "1";

        if ($request->department && $request->department != "All") {
            $cond .= " AND (dept_id = '" . $request->department . "')";
        }

        $owner = FcsOwner::where('staff_id', Auth::user()->id)->first();

        if (Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {

            $data = FcsMain::with('department')->whereRaw($cond);

        } elseif (isset($owner)) {

            $data = FcsMain::with('department')->whereRaw($cond)->where('dept_id', $owner->dept_id);
        }

        return datatables()::of($data)

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

                if (isset($owner)) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';

                } else {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                }
            })

            ->addColumn('log', function ($data) {
                return '<a href="/file-classification/' . $data->id . '/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action','log'])
            ->make(true);
    }

    public function storeNewActivity(Request $request)
    {
        $request->validate([
            'code'       => 'required',
            'fileName'   => 'required',
            'department' => 'required',
        ]);

        $data = FcsMain::create([
             'dept_id'    => $request->department,
             'code'       => $request->code,
             'file'       => $request->fileName,
             'remark'     => $request->remark,
             'created_by' => Auth::user()->id,
         ]);

        FcsLog::create([
           'code_id'    => $data->id,
           'log'        => "Create new activity: [" . $request->code . "]",
           'created_by' => Auth::user()->id,
        ]);

        return redirect()->to('file-classification/' . $data->id)->with('message', 'Successfully Created!');
    }

    public function updateActivity(Request $request)
    {
        $request->validate([
            'code'     => 'required',
            'fileName' => 'required',
        ]);

        $update = FcsMain::where('id', $request->id)->first();

        $update->update([
            'code'       => $request->code,
            'file'       => $request->fileName,
            'remark'     => $request->remark,
            'updated_by' => Auth::user()->id
        ]);

        FcsLog::create([
            'code_id'    => $request->id,
            'log'        => "Update activity: [" . $request->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('message', 'Successfully Updated!');
    }


    public function show(Request $request, $id)
    {
        $data          = FcsMain::where('id', $id)->first();
        $subActivities = FcsMainSub::where('code_id', $id)->get();
        $selectedSub   = $request->subActivities;
        $act           = FcsMainSubActivity::where('code_sub_id', $subActivities->pluck('id')->toArray())->exists();
        $owner         = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

        return view('file-classification.sub-activity', compact('data', 'subActivities', 'id', 'selectedSub', 'act', 'owner'));
    }

    public function subList($id)
    {
        $data = FcsMainSub::where('code_id', $id)->orderBy('code', 'ASC');

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->mainCode->dept_id)->first();

                if ($data->sub_activity === 'Y' && isset($owner)) {
                    return '<a href="/file-classification/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';
                } elseif($data->sub_activity !== 'Y' && isset($owner)) {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';
                } elseif($data->sub_activity === 'Y' && !isset($owner)) {
                    return '<a href="/file-classification/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
                } else {
                    return'<span class="badge badge-dark">NOT AVAILABLE</span>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action'])
            ->make(true);
    }

    public function storeNewSub(Request $request)
    {
        $request->validate([
            'code'     => 'required',
            'fileName' => 'required',
        ]);

        if ($request->subAct != null) {
            $data = FcsMainSub::create([
                'code_id'      => $request->id,
                'code'         => $request->code,
                'file'         => $request->fileName,
                'remark'       => $request->remark,
                'sub_activity' => 'Y',
                'created_by'   => Auth::user()->id,
            ]);

            FcsLog::create([
                'code_id'    => $request->id,
                'log'        => "Create new sub-activity: [" . $request->code . "]",
                'created_by' => Auth::user()->id,
            ]);

            return redirect()->to('file-classification/' . $request->id . '/' . $data->id)->with('message', 'Successfully Created!');
        } else {
            FcsMainSub::create([
            'code_id'      => $request->id,
            'code'         => $request->code,
            'file'         => $request->fileName,
            'remark'       => $request->remark,
            'created_by'   => Auth::user()->id,
        ]);

            FcsLog::create([
                'code_id'    => $request->id,
                'log'        => "Create new sub-activity: [" . $request->code . "]",
                'created_by' => Auth::user()->id,
            ]);

            return redirect()->back()->with('message', 'Successfully Created!');
        }
    }

    public function updateSub(Request $request)
    {
        $update = FcsMainSub::where('id', $request->id)->first();

        if ($request->subAct != null) {
            $update->update([
                'code'         => $request->code,
                'file'         => $request->fileName,
                'remark'       => $request->remark,
                'sub_activity' => 'Y',
                'updated_by'   => Auth::user()->id
            ]);

            FcsLog::create([
                'code_id'    => $update->code_id,
                'log'        => "Update sub-activity: [" . $request->code . "]",
                'created_by' => Auth::user()->id,
            ]);

            return redirect()->to('file-classification/' . $update->code_id . '/' . $request->id)->with('message', 'Successfully Created!');

        } else {
            $update->update([
                'code'       => $request->code,
                'file'       => $request->fileName,
                'remark'     => $request->remark,
                'updated_by' => Auth::user()->id
            ]);

            FcsLog::create([
                'code_id'    => $update->code_id,
                'log'        => "Update sub-activity: [" . $request->code . "]",
                'created_by' => Auth::user()->id,
            ]);

            return redirect()->back()->with('message', 'Successfully Updated!');
        }
    }

    public function showSubAct($id, $ids)
    {
        $mainSub       = FcsMainSub::where('id', $ids)->first();
        $data          = FcsMain::where('id', $id)->first();
        $subActivities = FcsMainSubActivity::where('code_sub_id', $ids)->get();
        $owner         = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

        return view('file-classification.file-sub', compact('data', 'mainSub', 'subActivities', 'id', 'ids', 'owner'));
    }

    public function subActList($id)
    {
        $data = FcsMainSubActivity::where('code_sub_id', $id);

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->subCode->mainCode->dept_id)->first();

                if (isset($owner)) {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                    class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';
                } else {
                    return'<span class="badge badge-dark">NOT AVAILABLE</span>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action'])
            ->make(true);
    }

    public function storeNewSubActivity(Request $request)
    {
        $request->validate([
            'code'     => 'required',
            'fileName' => 'required',
        ]);

        $data = FcsMainSub::where('id', $request->id)->first();

        FcsMainSubActivity::create([
             'code_sub_id' => $request->id,
             'code'        => $request->code,
             'file'        => $request->fileName,
             'remark'      => $request->remark,
             'created_by'  => Auth::user()->id,
         ]);

        FcsLog::create([
            'code_id'    => $data->code_id,
            'log'        => "Create new file: [" . $request->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('message', 'Successfully Created!');
    }

    public function updateSubActivity(Request $request)
    {
        $update = FcsMainSubActivity::where('id', $request->id)->first();

        $update->update([
            'code'       => $request->code,
            'file'       => $request->fileName,
            'remark'     => $request->remark,
            'updated_by' => Auth::user()->id
        ]);

        FcsLog::create([
            'code_id'    => $update->subCode->code_id,
            'log'        => "Update file: [" . $request->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function note()
    {
        $file = "FILE CLASSIFICATION SYSTEM NOTE.pdf";

        return Storage::disk('minio')->response('file-classification/' . $file);
    }

    public function owner()
    {
        return view('file-classification.owner');
    }

    public function getDepartment()
    {
        $department = SopDepartment::where('active', 'Y');

        return datatables()::of($department)

            ->editColumn('total', function ($department) {
                return FcsOwner::where('dept_id', $department->id)->count();
            })

            ->addColumn('action', function ($department) {
                return '<a href="/owner-list/' . $department->id . '" class="btn btn-sm btn-secondary"><i class="fal fa-pencil"></i></a>';
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function ownerList($id)
    {
        $data       = FcsOwner::where('dept_id', $id)->get();
        $department = SopDepartment::where('id', $id)->first();
        $staff      = Staff::all();

        return view('file-classification.owner-list', compact('data', 'id', 'staff', 'department'));
    }

    public function storeOwner(Request $request)
    {
        $request->validate([
            'admin'     => 'required',
        ]);

        $error = [];
        $message = '';

        foreach ($request->admin as $key => $value) {
            if (FcsOwner::where('dept_id', $request->id)->where('staff_id', $value)->count() > 0) {
                $staff = Staff::where('staff_id', $value)->first();
                $error[] = $staff->staff_name;
            } else {
                FcsOwner::create([
                    'staff_id'   => $value,
                    'dept_id'    => $request->id,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);

                $user = User::find($value);

                if (!$user->hasRole('File Manager')) {
                    $user->assignRole('File Manager');
                }
            }
        }

        if ($error) {
            $message = "[" . implode(',', $error) . "] already inserted";
        }

        if ($message) {
            return redirect()->back()->withErrors([$message]);
        } else {
            return redirect()->back()->with('message', 'Owner Added!');
        }
    }

    public function destroy($id)
    {
        $owner = FcsOwner::where('id', $id)->first();

        $user = User::find($owner->staff_id);

        $user->removeRole('File Manager');

        $exist = FcsOwner::find($id);
        $exist->update(['deleted_by' => Auth::user()->id]);
        $exist->delete();

        return redirect('owner-list/' . $owner->dept_id);
    }

    public function log($id)
    {
        $data = FcsMain::where('id', $id)->first();
        return view('file-classification.log', compact('id', 'data'));
    }

    public function logList($id)
    {
        $log = FcsLog::where('code_id', $id);

        return datatables()::of($log)

        ->addColumn('created_by', function ($log) {
            return $log->staff->staff_name;
        })

        ->addColumn('date', function ($log) {
            return $log->created_at->format('d/m/Y g:i A') ?? '';
        })

        ->addIndexColumn()
        ->rawColumns(['date'])
        ->make(true);
    }

}

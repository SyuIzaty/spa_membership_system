<?php

namespace App\Http\Controllers;

use App\FcsLog;
use App\User;
use App\Staff;
use App\FcsActivity;
use App\FcsOwner;
use App\FcsSubActivity;
use App\SopDepartment;
use App\FcsFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Rules\FileSubActivityCode;
use App\Rules\FileFilesCode;

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

            $data = FcsActivity::with('department');

        } elseif (isset($owner)) {

            $data = FcsActivity::with('department')->where('dept_id', $owner->dept_id);
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

                if (isset($owner) && Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                        <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-activity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                        <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-activity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (isset($owner)) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>';
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

            $data = FcsActivity::with('department')->whereRaw($cond);

        } elseif (isset($owner)) {

            $data = FcsActivity::with('department')->whereRaw($cond)->where('dept_id', $owner->dept_id);
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

                if (isset($owner) && Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                        <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-activity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                        <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-activity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (isset($owner)) {
                    return '<a href="/file-classification/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                        data-id="' . $data->id . '" data-code="' . $data->code . '"
                        data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                        class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>';
                }
            })

            ->addColumn('log', function ($data) {
                return '<a href="/log-file-classification/' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action','log'])
            ->make(true);
    }

    public function storeNewActivity(Request $request)
    {
        $request->validate([
            'fileName'   => 'required',
            'department' => 'required',
        ]);

        $data = FcsActivity::create([
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

        $update = FcsActivity::where('id', $request->id)->first();

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
        $data          = FcsActivity::where('id', $id)->first();
        $subActivities = FcsSubActivity::where('code_id', $id)->get();
        $selectedSub   = $request->subActivities;
        $act           = FcsFile::where('code_sub_id', $subActivities->pluck('id')->toArray())->exists();
        $owner         = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

        return view('file-classification.sub-activity', compact('data', 'subActivities', 'id', 'selectedSub', 'act', 'owner'));
    }

    public function subList($id)
    {
        $data = FcsSubActivity::where('code_id', $id)->orderBy('code', 'ASC');

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->mainCode->dept_id)->first();

                if (isset($owner) && Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin']) && $data->sub_activity === 'Y') {
                    return '<a href="/file-classification/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                    <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-subActivity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (isset($owner) && Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin']) && $data->sub_activity !== 'Y') {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                    <a href="#" data-target="#add-file" data-toggle="modal"
                    data-id="' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-plus"></i></a>
                    <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-subActivity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif ($data->sub_activity === 'Y' && isset($owner)) {
                    return '<a href="/file-classification/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>';
                } elseif($data->sub_activity !== 'Y' && isset($owner)) {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                    <a href="#" data-target="#add-file" data-toggle="modal"
                    data-id="' . $data->id . '" class="btn btn-sm btn-info"><i class="fal fa-plus"></i></a>';
                } elseif($data->sub_activity === 'Y' && !isset($owner)) {
                    return '<a href="/file-classification/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-subActivity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } else {
                    return'<div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-subActivity/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action'])
            ->make(true);
    }

    public function storeNewSub(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                new FileSubActivityCode(),
            ],
            'fileName' => 'required',
        ]);

        if ($request->subAct != null) {
            $data = FcsSubActivity::create([
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
            FcsSubActivity::create([
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
        $request->validate([
            'code' => [
                'required',
                new FileSubActivityCode(),
            ],
            'fileName' => 'required',
        ]);

        $update = FcsSubActivity::where('id', $request->id)->first();

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

    public function addFile(Request $request)
    {
        $request->validate(
            [
            'subAct'     => 'required',
        ],
            [
            'subAct.required' => 'The switch cannot be null!',
        ]
        );

        $update = FcsSubActivity::where('id', $request->id)->first();

        $update->update([
            'sub_activity' => 'Y',
            'updated_by'   => Auth::user()->id
        ]);

        FcsLog::create([
            'code_id'    => $update->code_id,
            'log'        => "Create new file: [" . $update->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->to('file-classification/' . $update->code_id . '/' . $request->id)->with('message', 'Successfully Created!');
    }


    public function showSubAct($id, $ids)
    {
        $mainSub       = FcsSubActivity::where('id', $ids)->first();
        $data          = FcsActivity::where('id', $id)->first();
        $subActivities = FcsFile::where('code_sub_id', $ids)->get();
        $owner         = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->dept_id)->first();

        return view('file-classification.file-sub', compact('data', 'mainSub', 'subActivities', 'id', 'ids', 'owner'));
    }

    public function subActList($id)
    {
        $data = FcsFile::where('code_sub_id', $id);

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                $owner = FcsOwner::where('staff_id', Auth::user()->id)->where('dept_id', $data->subCode->mainCode->dept_id)->first();

                if (isset($owner) && Auth::user()->hasAnyRole(['Library Executive', 'Library Manager', 'AQA Admin'])) {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>
                    <div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-files/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                } elseif (isset($owner)) {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                    class="btn btn-sm btn-success"><i class="fal fa-pencil"></i></a>';
                } else {
                    return'<div class="btn-group"><button class="btn btn-sm btn-danger btn-delete" data-remote="/delete-files/' . $data->id . '"><i class="fal fa-trash"></i></button></div>';
                }
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action'])
            ->make(true);
    }

    public function storeNewFile(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                new FileFilesCode(),
            ],
            'fileName' => 'required',
        ]);

        $data = FcsSubActivity::where('id', $request->id)->first();

        FcsFile::create([
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

    public function updateFile(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                new FileFilesCode(),
            ],
            'fileName' => 'required',
        ]);

        $update = FcsFile::where('id', $request->id)->first();

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
        $department = SopDepartment::with('owners')->where('active', 'Y');

        return datatables()::of($department)

            ->editColumn('total', function ($department) {
                return $department->owners->count();
            })

            ->addColumn('action', function ($department) {
                return '<a href="/owner-list/' . $department->id . '" class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
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
            'owner'     => 'required',
        ]);

        $error = [];
        $message = '';

        foreach ($request->owner as $key => $value) {
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
        $data = FcsActivity::where('id', $id)->first();
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

    public function deleteActivity($id)
    {
        $activity = FcsActivity::where('id', $id)->first();
        $subAct   = FcsSubActivity::where('code_id', $id);

        if ($subAct->exists()) {
            foreach($subAct->get() as $s) {
                $file = FcsFile::where('code_sub_id', $s->id);

                if ($file->exists()) {
                    foreach($file->get() as $f) {
                        $f->update(['deleted_by' => Auth::user()->id]);
                        $f->delete();
                    }
                }

                $s->update(['deleted_by' => Auth::user()->id]);
                $s->delete();
            }
        }

        FcsLog::create([
            'code_id'    => $id,
            'log'        => "Delete activity: [" . $activity->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        $exist = FcsActivity::find($id);
        $exist->update(['deleted_by' => Auth::user()->id]);
        $exist->delete();

        return response()->json();
    }

    public function deleteSubActivity($id)
    {
        $subAct   = FcsSubActivity::where('id', $id)->first();
        $file     = FcsFile::where('code_sub_id', $id);

        if ($file->exists()) {
            foreach($file->get() as $f) {
                $f->update(['deleted_by' => Auth::user()->id]);
                $f->delete();
            }
        }

        FcsLog::create([
            'code_id'    => $id,
            'log'        => "Delete sub-activity: [" . $subAct->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        $exist = FcsSubActivity::find($id);
        $exist->update(['deleted_by' => Auth::user()->id]);
        $exist->delete();

        return response()->json();
    }

    public function deleteFile($id)
    {
        $file = FcsFile::where('id', $id)->first();

        FcsLog::create([
            'code_id'    => $id,
            'log'        => "Delete file: [" . $file->code . "]",
            'created_by' => Auth::user()->id,
        ]);

        $exist = FcsFile::find($id);
        $exist->update(['deleted_by' => Auth::user()->id]);
        $exist->delete();

        return response()->json();
    }
}

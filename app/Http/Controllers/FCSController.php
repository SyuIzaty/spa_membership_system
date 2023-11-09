<?php

namespace App\Http\Controllers;

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

        $owner = FcsOwner::where('staff_id', Auth::user()->id)->first();

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
                return '<a href="/file-class/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            })

            ->addColumn('log', function ($data) {
                return '<a href="/file-class/' . $data->id . '/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
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
                return '<a href="/file-class/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            })

            ->addColumn('log', function ($data) {
                return '<a href="/file-class/' . $data->id . '/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['remark','action','log'])
            ->make(true);
    }

    public function storeNewFile(Request $request)
    {
        $request->validate([
            'code'     => 'required',
            'fileName' => 'required',
            'dept'     => 'required',
        ]);

        $data = FcsMain::create([
             'dept_id'    => $request->dept,
             'code'       => $request->code,
             'file'       => $request->fileName,
             'remark'     => $request->remark,
             'created_by' => Auth::user()->id,
         ]);

        return redirect()->to('file-class/' . $data->id)->with('message', 'Successfully Created!');
    }

    public function show(Request $request, $id)
    {
        $data          = FcsMain::where('id', $id)->first();
        $subActivities = FcsMainSub::where('code_id', $id)->get();
        $selectedSub   = $request->subActivities;
        $act = FcsMainSubActivity::where('code_sub_id', $subActivities->pluck('id')->toArray())->exists();

        return view('file-classification.file', compact('data', 'subActivities', 'id', 'selectedSub', 'act'));
    }

    public function subList($id)
    {
        $data = FcsMainSub::where('code_id', $id)->orderBy('code', 'ASC');

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                if ($data->sub_activity === 'Y') {
                    return '<a href="/file-class/' . $data->code_id . '/' . $data->id . '" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                    <a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
                } else {
                    return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '" data-subActs="' . $data->sub_activity . '"
                    class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
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

            return redirect()->to('file-class/' . $request->id . '/' . $data->id)->with('message', 'Successfully Created!');
        } else {
            FcsMainSub::create([
            'code_id'      => $request->id,
            'code'         => $request->code,
            'file'         => $request->fileName,
            'remark'       => $request->remark,
            'created_by'   => Auth::user()->id,
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

            return redirect()->to('file-class/' . $update->code_id . '/' . $request->id)->with('message', 'Successfully Created!');

        } else {
            $update->update([
                'code'       => $request->code,
                'file'       => $request->fileName,
                'remark'     => $request->remark,
                'updated_by' => Auth::user()->id
            ]);

            return redirect()->back()->with('message', 'Successfully Updated!');
        }
    }

    public function showSubAct($id, $ids)
    {
        $mainSub       = FcsMainSub::where('id', $ids)->first();
        $data          = FcsMain::where('id', $id)->first();
        $subActivities = FcsMainSubActivity::where('code_sub_id', $ids)->get();

        return view('file-classification.file-sub', compact('data', 'mainSub', 'subActivities', 'id', 'ids'));
    }

    public function subActList($id)
    {
        $data = FcsMainSubActivity::where('code_sub_id', $id);

        return datatables()::of($data)

            ->addColumn('remark', function ($data) {
                return isset($data->remark) ? ($data->remark) : 'N/A';
            })

            ->addColumn('action', function ($data) {

                return '<a href="#" data-target="#edit-modal-sub" data-toggle="modal"
                    data-id="' . $data->id . '" data-code="' . $data->code . '"
                    data-file="' . $data->file . '" data-remark="' . $data->remark . '"
                    class="btn btn-sm btn-primary"><i class="fal fa-pencil"></i></a>';
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

        FcsMainSubActivity::create([
             'code_sub_id' => $request->id,
             'code'        => $request->code,
             'file'        => $request->fileName,
             'remark'      => $request->remark,
             'created_by'  => Auth::user()->id,
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

        return redirect()->back()->with('message', 'Successfully Updated!');
    }

    public function note()
    {
        $file = "FILE CLASSIFICATION SYSTEM NOTE.pdf";

        return Storage::disk('minio')->response('file-classification/' . $file);
    }
}

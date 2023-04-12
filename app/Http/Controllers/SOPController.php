<?php

namespace App\Http\Controllers;

use App\Staff;
use App\SopList;
use App\SopDetail;
use Carbon\Carbon;
use App\SopDepartment;
use App\SopCrossDepartment;
use Illuminate\Http\Request;
use App\Rules\CodeFormatRule;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;

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
        $data = SopList::where('active', 'Y');

        return datatables()::of($data)
            ->addColumn('sop', function ($data) {
                return isset($data->sop) ? ($data->sop) : 'N/A';
            })

            ->addColumn('department', function ($data) {
                return isset($data->department->department_name) ? ($data->department->department_name) : 'N/A';
            })

            ->addColumn('action', function ($data) {
                return '<a href="/sop/' .$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            })

            ->addColumn('log', function ($data) {
                return '<a href="/sop/'.$data->id.'/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
            })

            ->addIndexColumn()
            ->rawColumns(['action','log'])
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

        ->addColumn('action', function ($data) {
            return '<a href="/sop/'.$data->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->addColumn('log', function ($data) {
            return '<a href="/sop/'.$data->id.'/log" class="btn btn-sm btn-info"><i class="fal fa-list-alt"></i></a>';
        })

        ->addIndexColumn()
        ->rawColumns(['action','log'])
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
                return '<a href="#" data-target="#edit" data-toggle="modal"
                data-id="'.$data->id.'" data-department="'.$data->department_id.'"
                data-title="'.$data->sop.'" data-status="'.$data->active.'"
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
        ->rawColumns(['action','status'])
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
        SopList::create([
            'sop'           => $request->title,
            'department_id' => $request->department,
            'active'        => $request->status,
            'created_by'    => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Add Successfully');
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

        return redirect()->back()->with('message', 'Update Successfully');
    }

    public function show($id)
    {
        $data       = SopList::where('id', $id)->first();
        $dateNow    = date(' j F Y ', strtotime(Carbon::now()->toDateTimeString()));
        $staff      = Staff::get();
        $department = SopDepartment::get();

        return view('sop.sop-details', compact('data', 'dateNow', 'staff', 'id','department'));
    }

    public function storeDetails(Request $request)
    {
        $validated = $request->validate([
            'code' => [
                'required',
                new CodeFormatRule(),
            ],
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

        return redirect()->back()->with('message', 'Save Successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\SopDepartment;
use App\SopList;
use Illuminate\Http\Request;

class SOPController extends Controller
{
    public function index(Request $request)
    {
        $selectedDepartment = $request->department;

        $department = SopDepartment::where('active', 'Y')->get();

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

}

<?php

namespace App\Http\Controllers\Stationery;

use App\IsmStatus;
use App\Departments;
use App\IsmApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StationeryReportExport;

class StationeryReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $department = Departments::all();

        $status = IsmStatus::all();

        $date = IsmApplication::all();

        return view('stationery.application-report', compact('department','status','date'));
    }

    public function data_stationery_report(Request $request)
    {
        $department = $request->input('department');

        $month = $request->input('month');

        $year = $request->input('year');

        $status = $request->input('status');

        $query = IsmApplication::query();

        if (!empty($department)) {
            $query->where('applicant_dept', $department);
        }

        if (!empty($month)) {
            $query->whereMonth('created_at', $month);
        }

        if (!empty($year)) {
            $query->whereYear('created_at', $year);
        }

        if (!empty($status)) {
            $query->where('current_status', $status);
        }

        $query->select('ism_applications.*');

        return datatables()::of($query)

            ->editColumn('id', function ($query) {

                return '#'.$query->id;
            })

            ->addColumn('created_at', function ($query) {

                return date('d-m-Y', strtotime($query->created_at)) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('applicant_id', function ($query) {

                return strtoupper($query->staff->staff_name) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('current_status', function ($query) {

                return strtoupper($query->status->status_name) ?? '<div style="color:red;">--</div>';
            })

            ->editColumn('applicant_dept', function ($query) {

                return strtoupper(optional($query->department)->department_name) ?? '<div style="color:red;">--</div>';
            })

            ->rawColumns(['current_status', 'applicant_id', 'id', 'created_at', 'applicant_dept'])

            ->make(true);
    }

    public function stationery_report($department, $month, $year, $status, $type)
    {
        return Excel::download(new StationeryReportExport($department, $month, $year, $status, $type), 'Stationery Report.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

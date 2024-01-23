<?php

namespace App\Http\Controllers\Inventory;

use Auth;
use App\User;
use App\Rental;
use App\AssetCustodian;
use App\AssetDepartment;
use Illuminate\Http\Request;
use App\Exports\RentalReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class RentalReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departmentCustodian = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id')->toArray();

        $department = AssetDepartment::whereIn('id', $departmentCustodian)->get();

        $user = User::where('category', 'STF')->get();

        return view('inventory.rental.rental-report', compact('department','user'));
    }

    public function data_excel_report(Request $request)
    {
        $department = $request->input('department');

        $asset = (array) $request->input('asset');

        $renter = $request->input('renter');

        $query = Rental::query();

        if (empty($department) && empty($asset) && empty($renter)) {

            $query;

        } elseif (!empty($department) && empty($asset) && empty($renter)) {

            $query->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            });

        } elseif (!empty($department) && !empty($asset) && empty($renter)) {

            $query->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->whereIn('asset_id', $asset);

        } elseif (!empty($department) && empty($asset) && !empty($renter)) {

            $query->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->where('staff_id', $renter);

        } elseif (!empty($department) && !empty($asset) && !empty($renter)) {

            $query->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->whereIn('asset_id', $asset)->where('staff_id', $renter);

        } else {

            $query = $query->where('id', '<', 0);
        }

        $query = $query->select('inv_rentals.*');

        return datatables()::of($query)

            ->editColumn('asset_id', function ($query) {

                return $query->asset->asset_name ?? 'N/A';
            })

            ->editColumn('staff_id', function ($query) {

                return $query->staff->staff_name ?? 'N/A';
            })

            ->editColumn('status', function ($query) {

                if($query->status=='0')
                {
                    $color = '#CC0000';
                    return '<div style="text-transform: uppercase; color:' . $color . '"><b>CHECKOUT</b></div>';
                }
                else
                {
                    $color = '#3CBC3C';
                    return '<div style="text-transform: uppercase; color:' . $color . '"><b>RETURNED</b></div>';
                }
            })

            ->editColumn('checkout_date', function ($query) {

                return isset($query->checkout_date) ? date(' Y-m-d ', strtotime($query->checkout_date)) : 'N/A';
            })

            ->editColumn('return_date', function ($data) {

                return isset($query->return_date) ? date(' Y-m-d ', strtotime($query->return_date)) : 'N/A';
            })

            ->rawColumns(['asset_id', 'staff_id', 'status', 'checkout_date', 'return_date'])

            ->make(true);
    }

    public function rental_report_excel($department, $asset, $renter)
    {
        return Excel::download(new RentalReportExport($department, $asset, $renter), 'Rental Report Excel.xlsx');
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

<?php

namespace App\Http\Controllers;

use App\eKenderaanDrivers;
use Illuminate\Http\Request;
use App\eKenderaanAssignDriver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class eKenderaanDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $driver = eKenderaanDrivers::where('status', 'Y')->get();

        return view('eKenderaan.dashboard', compact('driver'));
    }

    public function dashboardDriver(Request $request)
    {
        $driverId = $request->input('driver');
        $year = $request->input('year');
        $month = $request->input('month');

        $driverTotals = [];

        // $query = eKenderaanAssignDriver::selectRaw('
        //         ekn_assign_drivers.driver_id,
        //         ekn_drivers.name as driver_name,
        //         COUNT(ekn_assign_drivers.id) as total_assignments
        //     ')
        //     ->leftJoin('ekn_details as d', function ($join) {
        //         $join->on('ekn_assign_drivers.ekn_details_id', '=', 'd.id')
        //             ->whereNull('d.deleted_at');
        //     })
        //     ->leftJoin('ekn_drivers', 'ekn_assign_drivers.driver_id', '=', 'ekn_drivers.id')
        //     ->whereNull('ekn_assign_drivers.deleted_at')
        //     ->groupBy('ekn_assign_drivers.driver_id');

        $query = eKenderaanDrivers::selectRaw('
        ekn_drivers.id as driver_id,
        ekn_drivers.name as driver_name,
        COUNT(ekn_assign_drivers.id) as total_assignments')
        ->leftJoin('ekn_assign_drivers', function ($join) {
            $join->on('ekn_drivers.id', '=', 'ekn_assign_drivers.driver_id')
                ->whereNull('ekn_assign_drivers.deleted_at');
        })
        ->leftJoin('ekn_details as d', function ($join) {
            $join->on('ekn_assign_drivers.ekn_details_id', '=', 'd.id')
                ->whereNull('d.deleted_at');
        })
        ->where('ekn_drivers.status', 'Y')
        ->whereNull('ekn_drivers.deleted_at')
        ->groupBy('ekn_drivers.id');


        if ($driverId) {
            $query->where('ekn_drivers.id', $driverId);
        }

        if ($year) {
            $query->whereYear('d.depart_date', $year);
        }

        if ($month) {
            $monthNumbers = collect($month)->map(function ($months) {
                return date('m', strtotime($months));
            })->toArray();

            $query->whereIn(DB::raw('MONTH(d.depart_date)'), $monthNumbers);
        }


        $assignments = $query->get();

        $monthData = '<tr class="bg-primary-50 text-center">';
        $monthData .= '<th>DRIVER</th>';

        if (isset($month)) {
            if (is_array($month)) {

                $monthList = $month;

                foreach ($monthList as $selectedMonth) {
                    $monthData .= '<th>' . date('F', mktime(0, 0, 0, $selectedMonth, 1)) . '</th>';
                }
            }
        } else {

            $monthNames = new Collection();

            for ($i = 1; $i <= 12; $i++) {
                $monthNames->push(date('F', mktime(0, 0, 0, $i, 1)));
            }

            foreach ($monthNames as $selectedMonth) {
                $monthData .= '<th>' . $selectedMonth . '</th>';
            }
        }

        $monthData .= '<th>TOTAL</th>';
        $monthData .= '</tr>';

        $driverData = '';

        foreach ($assignments as $row) {
            $driverData .= '<tr class="text-center">';
            $driverData .= '<td>' . $row->driver_name . '</td>';

            $totalAssignments = 0;

            if (isset($month)) {
                if (is_array($month)) {
                    $monthNames = $month;
                }
            } else {
                $monthNames = new Collection();
                for ($i = 1; $i <= 12; $i++) {
                    $monthNames->push(date('F', mktime(0, 0, 0, $i, 1)));
                }
            }

            if (isset($year)) {
                foreach ($monthNames as $selectedMonth) {

                    $countAssignment = eKenderaanAssignDriver::where('driver_id', $row->driver_id)
                    ->whereHas('details', function ($query) use ($year, $selectedMonth) {
                        $query->whereYear('depart_date', '=', $year)
                        ->whereMonth('depart_date', '=', date('m', strtotime($selectedMonth)));
                    })->count();

                    $totalAssignments += $countAssignment;
                    if (!isset($driverTotals[$selectedMonth])) {
                        $driverTotals[$selectedMonth] = 0;
                    }
                    $driverTotals[$selectedMonth] += $countAssignment;
                    $driverData .= '<td>' . $countAssignment . '</td>';
                }
            } else {
                foreach ($monthNames as $selectedMonth) {
                    $countAssignment = eKenderaanAssignDriver::where('driver_id', $row->driver_id)
                    ->whereHas('details', function ($query) use ($selectedMonth) {
                        $query->whereMonth('depart_date', '=', date('m', strtotime($selectedMonth)));
                    })->count();

                    $totalAssignments += $countAssignment;
                    if (!isset($driverTotals[$selectedMonth])) {
                        $driverTotals[$selectedMonth] = 0;
                    }
                    $driverTotals[$selectedMonth] += $countAssignment;
                    $driverData .= '<td>' . $countAssignment . '</td>';
                }
            }

            $driverData .= '<td>' . $totalAssignments . '</td>';
            $driverData .= '</tr>';
        }

        $totalData = '<tr class="text-center bg-primary-50">';
        $totalData .= '<td><b>TOTAL</b></td>';

        foreach ($driverTotals as $total) {
            $totalData .= '<td><b>' . $total . '</b></td>';
        }

        $totalColumnSum = array_sum($driverTotals);
        $totalData .= '<td><b>' . $totalColumnSum . '</b></td>';

        $totalData .= '</tr>';

        return response()->json(['monthData' => $monthData, 'driverData' => $driverData, 'totalData' => $totalData]);
    }
}

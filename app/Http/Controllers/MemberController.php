<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Booking;
use App\Customer;
use App\CustomerPlan;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return view('admin-display.member');
    }

    public function dataMember()
    {
        $mem = Customer::whereHas('customerPlans', function ($query) {
            $query->active();
        })->get();

        return datatables()::of($mem)

        ->addColumn('action', function ($mem) {
            return '<div class="btn-group">
                        <a href="/show-member-detail/' . $mem->user_id . '" class="btn btn-sm btn-primary mr-1">
                            <i class="fal fa-eye"></i>
                        </a>
                    </div>';
        })

        ->addColumn('membership_id', function ($mem) {

            $activePlan = $mem->customerPlans()
                ->active()
                ->orderBy('start_date', 'asc')
                ->first();

            if ($activePlan) {
                return $activePlan->membership_id;
            }
            return 'No Membership ID';
        })

        ->addColumn('plan_id', function ($mem) {

            $activePlan = $mem->customerPlans()
                ->active()
                ->orderBy('start_date', 'asc')
                ->first();

            if ($activePlan) {
                return $activePlan->membershipPlan->plan_name ?? 'No Plan Name';
            }
            return 'No Plan ID';
        })

        ->addColumn('membership_duration', function ($mem) {

            $activePlan = $mem->customerPlans()
                ->active()
                ->orderBy('start_date', 'asc')
                ->first();

            if ($activePlan) {
                return date('Y/m/d', strtotime($activePlan->start_date)) . ' - ' . date('Y/m/d', strtotime($activePlan->end_date));
            }
            return 'No Membership Duration';
        })

        ->addIndexColumn()
        ->rawColumns(['action', 'plan_id', 'membership_duration', 'membership_id'])
        ->make(true);
    }

    public function dataNonMember()
    {
        $mem = Customer::whereHas('customerPlans', function ($query) {
            $query->active();
        })->pluck('user_id')->toArray();

        $nmem = Customer::whereNotIn('user_id', $mem)->get();

        return datatables()::of($nmem)

        ->addColumn('action', function ($nmem) {
            return '<div class="btn-group">
                        <a href="/show-member-detail/' . $nmem->user_id . '" class="btn btn-sm btn-primary mr-1">
                            <i class="fal fa-eye"></i>
                        </a>
                    </div>';
        })

        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    public function showMemberDetail($id)
    {
        $member = Customer::where('user_id', $id)->first();

        return view('admin-display.member-detail', compact('member'));
    }

    public function dataMemberBooking($id)
    {
        $bkg = Booking::where('customer_id', $id)->get();

        return datatables()::of($bkg)

        ->editColumn('booking_time', function ($bkg) {

            return date('h:i:s A', strtotime($bkg->booking_time)) ?? 'No information to display';
        })

       ->editColumn('booking_status', function ($bkg) {

            return $bkg->bookingStatus->status_name ?? 'No information to display';
       })

        ->editColumn('booking_payment', function ($bkg) {

            return 'RM '.$bkg->booking_payment ?? 'No information to display';
        })

       ->editColumn('booking_payment_status', function ($bkg) {

            return '<p style="color: green">'.$bkg->booking_payment_status.'</p>' ?? 'No information to display';
       })

       ->addColumn('service_id', function ($bkg) {
            $services = '';

            foreach ($bkg->bookingServices as $service) {
                $services .= '<li style="text-align:left">' . $service->service->service_name . '</li>';
            }

            return '<ul>' . $services . '</ul>';
        })

        ->addIndexColumn()
        ->rawColumns(['booking_time','booking_status','booking_payment_status','service_id','booking_payment'])
        ->make(true);
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

<?php

namespace App\Http\Controllers;

use Auth;
use App\Staff;
use App\Service;
use App\Customer;
use App\Booking;
use App\Discount;
use App\PlanService;
use App\CustomerPlan;
use App\BookingService;
use App\BookingDiscount;
use App\BookingStatusTrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

class CustomerBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::check()) {

            $services = Service::all();

            $staffs = Staff::whereNull('staff_end_date')
                ->whereHas('user', function($query) {
                    $query->where('role_id', 'SPA002');
                })
                ->get();

            $customer = Customer::where('user_id', Auth::user()->id)->first();

            $discounts = 0;

            $freeServices = collect();

            if ($customer) {

                $activePlan = CustomerPlan::where('user_id', Auth::user()->id)
                    ->active()
                    ->first();

                if ($activePlan) {
                    $freeServices = PlanService::where('plan_id', $activePlan->plan_id)
                        ->with('service')
                        ->get()
                        ->pluck('service_id');

                    $existBooking = Booking::where('customer_id', $customer->id)->exists();

                    if ($existBooking) {
                        $discounts = Discount::whereDate('discount_start_date', '<=', now())
                            ->whereDate('discount_end_date', '>=', now())
                            ->first();
                    } else {
                        $firstBookingDiscount = Discount::where('id', 1)->first();

                        $additionalDiscount = Discount::whereDate('discount_start_date', '<=', now())
                            ->whereDate('discount_end_date', '>=', now())
                            ->first();

                        $discounts = collect([$firstBookingDiscount, $additionalDiscount])
                            ->filter()
                            ->values();
                    }
                }

                return view('customer-display.booking', compact('services', 'discounts', 'staffs', 'freeServices'));
            } else {
                return view('customer-display.booking', compact('services', 'staffs'));
            }
        } else {
            return view('customer-display.booking');
        }
    }

    public function registerBooking(Request $request)
    {
        $customer = Customer::where('user_id', Auth::user()->id)->first();

        $services = json_decode($request->services, true);

        $discounts = json_decode($request->discounts, true);

        $totalPrice = $request->total_price;

        $booking = Booking::create([
            'customer_id'               => $customer->user_id,
            'booking_date'              => $request->booking_date,
            'booking_time'              => $request->booking_time,
            'booking_status'            => 1,
            'booking_payment'           => $totalPrice,
            'booking_payment_status'    => 'Paid',
            'booking_duration'          => $request->total_duration,
            'staff_id'                  => $request->staff_id,
        ]);

        if (!empty($services)) {
            foreach ($services as $service) {
                BookingService::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service['serviceId'],
                ]);
            }
        }

        if (!empty($discounts)) {
            foreach ($discounts as $discount) {
                BookingDiscount::create([
                    'booking_id'    => $booking->id,
                    'discount_id'   => $discount['id'],
                ]);
            }
        }

        BookingStatusTrack::create([
            'booking_id'            => $booking->id,
            'booking_status_id'     => 1,
            'created_by'            => $booking->customer_id,
        ]);

        $pdf = PDF::loadView('customer-display.booking-pdf', compact('booking'));

        $data_email = [
            'greeting'                  => 'Dear Our Valued Member,',
            'introduction'              => 'We are pleased to inform you that your booking has been successfully reserved. Below are the details:',
            'full_name'                 => $booking->customer->customer_name,
            'booking_date'              => date('d/m/Y', strtotime($booking->booking_date)),
            'booking_time'              => date('H:i A', strtotime($booking->booking_time)),
            'booking_payment'           => 'RM '.$booking->booking_payment,
            'booking_payment_status'    => $booking->booking_payment_status,
            'closing'                   => 'If you have any questions, feel free to contact us. Thank you for being a valued member!',
        ];

        Mail::send('customer-display.booking-mail', $data_email, function ($message) use ($booking, $pdf) {
            $message->subject('Raudhah Serenity: Booking Reservation');
            $message->to($booking->customer->customer_email)
                    ->attachData($pdf->output(), 'booking receipt.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });

        return redirect()->back()->with('message', 'Booking has been successfully reserved. Please check your email for the receipt.');
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

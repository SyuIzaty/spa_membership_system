<?php

namespace App\Http\Controllers;

use Auth;
use App\Customer;
use App\Discount;
use App\CustomerPlan;
use App\MembershipPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;

class CustomerMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = MembershipPlan::all();

        $discounts = Discount::all();

        return view('customer-display.membership', compact('plans', 'discounts'));
    }

    public function registerMembership(Request $request)
    {
        $request->validate([
            'customer_name'         => 'required|string',
            'customer_email'        => 'required|email',
            'customer_phone'        => 'required|string',
            'plan_id'               => 'required|integer',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'membership_payment'    => 'required|numeric',
        ]);

        $customer = Customer::where('user_id', Auth::user()->id)->first();

        $membershipId = 'MBR' . Auth::user()->id;

        $customerPlan = new CustomerPlan([
            'user_id'                   => Auth::user()->id,
            'membership_id'             => $membershipId,
            'plan_id'                   => $request->plan_id,
            'start_date'                => $request->start_date,
            'end_date'                  => $request->end_date,
            'membership_payment'        => $request->membership_payment,
            'membership_payment_status' => 'Paid',
        ]);

        $customer->customerPlans()->save($customerPlan);

        $pdf = PDF::loadView('customer-display.membership-pdf', compact('customerPlan'));

        $data_email = [
            'greeting'                  => 'Dear Our Valued Member,',
            'introduction'              => 'We are pleased to inform you that your membership has been successfully registered. Below are the details:',
            'full_name'                 => $customerPlan->customer->customer_name,
            'membership_id'             => $customerPlan->membership_id,
            'membership_start'          => date('d/m/Y', strtotime($customerPlan->start_date)),
            'membership_end'            => date('d/m/Y', strtotime($customerPlan->end_date)),
            'membership_payment'        => 'RM '.$customerPlan->membership_payment,
            'membership_payment_status' => $customerPlan->membership_payment_status,
            'closing'                   => 'If you have any questions, feel free to contact us. Thank you for being a valued member!',
        ];

        Mail::send('customer-display.membership-mail', $data_email, function ($message) use ($customerPlan, $pdf) {
            $message->subject('Raudhah Serenity: Membership Registration');
            $message->to($customerPlan->customer->customer_email)
                    ->attachData($pdf->output(), 'membership_receipt.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });

        return redirect()->back()->with('message', 'Membership has been successfully registered. Please check your email for the receipt.');
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

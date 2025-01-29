<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer-display.profile');
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'id'                => 'required|exists:users,id',
            'customer_name'     => 'required|string|max:255',
            'customer_ic'       => 'nullable|string|max:50',
            'customer_email'    => 'required|email|max:255',
            'customer_phone'    => 'required|string|max:15',
            'customer_gender'   => 'required|in:M,F',
            'customer_address'  => 'nullable|string',
            'customer_state'    => 'nullable|string|max:100',
            'customer_postcode' => 'nullable|string|max:10',
        ]);

        $customer = Customer::where('user_id', $validatedData['id'])->firstOrFail();

        $customer->update([
            'customer_name'         => $validatedData['customer_name'],
            'customer_ic'           => $validatedData['customer_ic'],
            'customer_email'        => $validatedData['customer_email'],
            'customer_phone'        => $validatedData['customer_phone'],
            'customer_gender'       => $validatedData['customer_gender'],
            'customer_address'      => $validatedData['customer_address'],
            'customer_state'        => $validatedData['customer_state'],
            'customer_postcode'     => $validatedData['customer_postcode'],
        ]);

        return redirect()->back()->with('message', 'Profile updated successfully');
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

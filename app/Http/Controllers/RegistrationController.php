<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Country;
use App\Programme;
use App\Major;
use App\State;
use App\Gender;
use App\ApplicantContact;
use App\ApplicantEmergency;
use App\ApplicantGuardian;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::all();
        $programme = Programme::all();
        $major = Major::all();
        $state = State::all();
        return view('registration.index', compact('country','programme','major'));
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
        $detail = Applicant::create([
            'applicant_name' => $request->applicant_name,
            'applicant_ic' => $request->applicant_ic,
            'applicant_phone' => $request->applicant_phone,
            'applicant_email' => $request->applicant_email,
            'applicant_nationality' => $request->applicant_nationality,
            'applicant_programme' => $request->applicant_programme,
            'applicant_major' => $request->applicant_major,
            'applicant_programme_2' => $request->applicant_programme_2,
            'applicant_major_2' => $request->applicant_major_2,
            'applicant_programme_3' => $request->applicant_programme_3,
            'applicant_major_3' => $request->applicant_major_3,
        ]);

        $applicant_detail = Applicant::where('applicant_ic',$request->applicant_ic)->with(['country','programme','programmeTwo','programmeThree'])->first();

        return view('registration.printRef', compact('detail','applicant_detail'));
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
        $applicant = Applicant::where('id', $id)->with(['applicantContactInfo'])->first();
        $country = Country::all();
        $gender = Gender::all();
        $state = State::all();
        return view('registration.edit', compact('applicant','country','gender','state'));
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
        Applicant::find($id)->update([
            'applicant_name' => $request->applicant_name,
            'applicant_ic' => $request->applicant_ic,
            'applicant_phone' => $request->applicant_phone,
            'applicant_email' => $request->applicant_email,
            'applicant_nationality' => $request->applicant_nationality,
            'applicant_gender' => $request->applicant_gender,
            'applicant_dob' => $request->applicant_dob,
            'applicant_phone' => $request->applicant_phone,
        ]);

        ApplicantContact::create([
            'applicant_id' => $id,
            'applicant_address_1' => $request->applicant_address_1,
            'applicant_address_2' => $request->applicant_address_2,
            'applicant_poscode' => $request->applicant_poscode,
            'applicant_city' => $request->applicant_city,
            'applicant_state' => $request->applicant_state,
            'applicant_country' => $request->applicant_country,
        ]);
        ApplicantContact::create($request->all());
        ApplicantEmergency::create($request->all());
        ApplicantGuardian::create($request->all());
        return view('registration.printReg');
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

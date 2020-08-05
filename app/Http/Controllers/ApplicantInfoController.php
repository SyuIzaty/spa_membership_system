<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantInfo;
use Illuminate\Http\Request;
use App\Programme;
use DB;
use Illuminate\Support\Str;

class ApplicantInfoController extends Controller
{
    public $program;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view ('applicant.test');
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //return view ('applicant.create');
        $programme = DB::select('select * from programmes');
        return view('applicant.create',['programme'=>$programme]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ApplicantInfo $applicantinfo, Programme $programme)
    {
        
        // Validate posted form data
        $validated = $request->validate([
        'applicant_name' => 'required|string|min:|max:100',
        'applicant_ic' => 'required|string|min:|max:100',
        'applicant_email' => 'required|string|min:|max:100',
        'applicant_phone' => 'required|string|min:|max:100',
        'applicant_nationality' => 'required|string|min:|max:100',
        'applicant_programme' => 'required|string|min:|max:100',
        
        
    ]);
    
    // Create and save post with validated data
    $applicantinfo = Applicant::create($validated);

    // Redirect the user to the created post with a success notification
    return redirect(route('applicantinfo.show',$applicantinfo,$programme))->with('notification', 'Applicant created!');

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicantInfo  $applicantInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicantInfo $applicantInfo)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApplicantInfo  $applicantinfo
     * @param  \App\Programme $programme
     * @return \Illuminate\Http\Response
     */
    public function show(ApplicantInfo $applicantinfo, Programme $programme)
    {
        


    $applicantinfo=DB::table('applicant')
                    ->join('applicant','applicant.applicant_programme','=','applicant.applicant_programme')
                    ->join('programmes','programmes.programme_name','=','programmes.programme_name')
                    ->select('applicant.*','applicant.applicant_programme','programmes.programme_name')
                    ->get();
       
    
    
      return view('applicant.show',compact('applicantinfo','programme'));
      

    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicantInfo  $applicantInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicantInfo $applicantInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicantInfo  $applicantInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicantInfo $applicantInfo)
    {
        //
    }
}

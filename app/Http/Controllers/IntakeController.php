<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\ApplicantStatus;
use App\IntakeDetail;
use Illuminate\Http\Request;
use App\Intakes;
use App\IntakeType;
use App\Programme;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intakeInfo = Intakes::all();
        $programme = Programme::all();
        return view('intake.index', compact('intakeInfo', 'programme'));
        // return view('intake.index', compact('intake'));
    }

    public function data_allintake()
    {
        $intakeInfo = Intakes::select('*');

        return datatables()::of($intakeInfo)
        ->addColumn('action', function ($intakeInfo) {

            return '<a href="/intake/'.$intakeInfo->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/intake/' . $intakeInfo->id . '"> Delete</button>'
            ;
        })

        ->make(true);
    }

    public function create()
    {
        return view('intake.create');
    }

    public function createType()
    {
        return view('intake.createType');
    }

    public function view()
    {
        return view('intake.createIntake');
    }

    public function store(Request $request)
    {
        $request->validate([
            'intake_type_code' => 'required',
            'intake_type_description' => 'required',
        ]);

        // IntakeType::create($request->only(['intake_type_code', 'intake_type_description']));
        Intakes::where('status', '1')->update(['status' => 0]);
        Intakes::create([
            'intake_code' => $request->intake_type_code,
            'intake_description' => $request->intake_type_description,
            'intake_app_open' => $request->intake_app_open,
            'intake_app_close' => $request->intake_app_close,
            'intake_check_open' => $request->intake_check_open,
            'intake_check_close' => $request->intake_check_close,
            'status' => '1'
        ]);

        // return $this->showProgramInfo($request->intake_type_code);
        return redirect()->route('intake.index')
            ->with('success', 'Intake created successfully');
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
        $intake = Intakes::find($id);
        $intake_details = IntakeDetail::where('intake_code', $id)->get();
        $intake_detail = $intake_details->load('programme', 'intakeType');
        $programme = Programme::all();
        $intake_type = IntakeType::all();
        return view('intake.edit', compact('intake', 'intake_detail', 'programme', 'intake_type'));
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

        $this->validate($request, [
            'intake_code' => 'required',
            'intake_description' => 'required',
            'intake_app_open' => 'required',
            'intake_app_close' => 'required',
            'intake_check_open' => 'required',
            'intake_check_close' => 'required',
        ]);

        Intakes::find($id)->update($request->all());

        return redirect()->route('intake.index')
            ->with('success', 'Intake updated successfully');
    }

    public function intakeInfo()
    {
        $intakeInfo = Intakes::all();
        return view('intake.info', compact('intakeInfo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $exist = Intakes::find($id);
        $exist->delete();
        return redirect()->route('intakes.index');
    }

    public function showProgramInfo($intake_code)
    {
        $intakedetail = IntakeDetail::where('intake_code', $intake_code)->get();
        $programme = Programme::all();
        $intake = Intakes::where('id', $intake_code)->get();
        return redirect()->back();
    }

    public function createProgramInfo(Request $request)
    {
        $request->validate([
            'intake_code' => 'required'
        ]);

        IntakeDetail::where('intake_programme', $request->intake_programme)->where('intake_code', $request->intake_code)->where('status', '1')->update(['status' => 0]);
        IntakeDetail::create($request->all());
        IntakeDetail::where('status', Null)->where('intake_programme', $request->intake_programme)->where('intake_code', $request->intake_code)->update(['status' => 1]);
        return $this->showProgramInfo($request->intake_code);
    }

    public function deleteProgramInfo($id)
    {
        $exist = IntakeDetail::find($id);
        $exist->delete();
        return response()->json(['success', 'Successfully deleted!']);
    }

    public function offer()
    {
        $applicants = Applicantstatus::where('applicant_status', 'Selected')->with(['applicant', 'programme'])->get();
        foreach ($applicants as $apps) {
            $applied_date = date("Y-m-d", strtotime($apps->applicant->created_at));
            $app = IntakeDetail::where('intake_code', $apps->applicant->intake_id)->where('intake_programme', $apps->applicant_programme)
                ->where('status', '1')->with(['intakes'])->get();
        }

        $this->studentID($app, $applied_date);

        return view('intake.offer', compact('applicants'));
    }

    public function letter(Request $request)
    {
        $applicant = Applicant::where('id', $request->applicant_id)->first();
        $programme = Programme::where('id', $request->programme_id)->first();
        $intakes = IntakeDetail::where('status', '1')->where('intake_code', $request->intake_id)->where('intake_programme', $request->programme_id)
            ->first();

        $pdf = PDF::loadView('intake.pdf', compact('applicant', 'programme', 'intakes'));
        return $pdf->stream('Offer Letter_' . $request->applicant_name . '.pdf');
    }
}

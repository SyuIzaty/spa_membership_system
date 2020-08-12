<?php

namespace App\Http\Controllers;

use App\IntakeDetail;
use Illuminate\Http\Request;
use App\Intakes;
use App\IntakeType;
use Illuminate\Support\Facades\Redirect;

class IntakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intake = IntakeType::all();
        return view('intake.index', compact('intake'));
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

        IntakeType::create($request->only(['intake_type_code', 'intake_type_description']));

        Intakes::create([
            'intake_code' => $request->intake_type_code,
            'intake_description' => $request->intake_type_description,
            'intake_app_open' => $request->intake_app_open,
            'intake_app_close' => $request->intake_app_close,
            'intake_check_open' => $request->intake_check_open,
            'intake_check_close' => $request->intake_check_close,
            'status' => 'Active'
        ]);

        return $this->showProgramInfo($request->intake_type_code);
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
    public function edit(intakeType $intakeType)
    {
        return view('intake.edit',compact('intakeType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IntakeType $intakeType)
    {
        $request->validate([
            'intake_type_code' => 'required',
            'intake_type_description' => 'required',
        ]);

        $intakeType->update($request->all());

        return redirect()->route('intake.index')
                        ->with('success','Intake updated successfully');
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
    public function destroy(IntakeType $intakeType)
    {
        $intakeType->delete();

        return redirect()->route('intake.index')->with('success','Intake deleted successfully');
    }

    public function showProgramInfo($intake_code)
    {
        $intakedetail = IntakeDetail::where('intake_code',$intake_code)->get();
        return view('intake.createprogram', compact('intake_code', 'intakedetail'));
    }

    public function createProgramInfo(Request $request)
    {
        $request->validate([
            'intake_code' => 'required'
        ]);

        IntakeDetail::create($request->all());

        return $this->showProgramInfo($request->intake_code);
    }

}
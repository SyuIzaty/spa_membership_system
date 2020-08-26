<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IntakeType;

class IntakeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $intakeType = IntakeType::all();
        return view('intakeType.index', compact('intakeType'));
    }


    public function data_intakeType()
    {
        $intake = IntakeType::all();

        return datatables()::of($intake)
        ->addColumn('action', function ($intake) {

            return '
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/intakeType/' . $intake->id . '"> Delete</button>'
            ;
        })

        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        IntakeType::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'intake_type_description' => 'required',
        ]);

        IntakeType::create([
            'id' => $request->id,
            'intake_type_description' => $request->intake_type_description,
        ]);
        return redirect()->back();

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
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = IntakeType::find($id);
        $exist->delete();
        return response()->json(['success'=>'Intake deleted successfully.']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBatchRequest;
use App\Batch;
use App\Programme;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('batch.index');
    }

    public function data_allbatch()
    {
        $batch = Batch::all();
        return datatables()::of($batch)
        ->addColumn('batch_status',function($batch){
            if($batch->status == '1')
            {
                return 'Active';
            }else{
                return 'Inactive';
            }
        })
        ->addColumn('action', function ($batch) {

            return '<a href="/batch/'.$batch->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>
            <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/batch/' . $batch->id . '"> Delete</button>'
            ;
        })

        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programme = Programme::all();
        return view('batch.create', compact('programme'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBatchRequest $request)
    {
        Batch::where('programme_code',$request->programme_code)->where('status','1')->update(['status'=>0]);
        Batch::create($request->all());

        return redirect()->route('batch.index');
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
        $batch = Batch::find($id);
        $programme = Programme::all();
        return view('batch.edit', compact('batch', 'programme'));
    }

    // public function data($id)
    // {
    //     $all = Batch::find($id);
    //     $applicant_major = $all->major;
    //     return response()->json($applicant_major);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBatchRequest $request, $id)
    {
        Batch::find($id)->update($request->all());

        return redirect()->route('batch.index')->with('success', 'Batch Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Batch::find($id);
        $exist->delete();
        return redirect()->route('intakes.index');
    }
}

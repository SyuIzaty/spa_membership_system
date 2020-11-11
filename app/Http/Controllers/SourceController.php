<?php

namespace App\Http\Controllers;

use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->id);
        $source = Source::where('id', $request->id)->first();
        return view('param.source.index', compact('source'));
    }

    public function data_allSource()
    {
        $source = Source::all();

        return datatables()::of($source)
        ->addColumn('action', function ($source) {

            return '
            <a href="" data-target="#crud-modals" data-toggle="modal" data-source="'.$source->id.'" data-name="'.$source->source_name.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/param/source/' . $source->id . '"><i class="fal fa-trash"></i>  Delete</button>'
            ;
        })

        ->editColumn('created_at', function ($source) {

            return date(' Y-m-d | H:i A', strtotime($source->updated_at) );
        })

        ->make(true);
    }

    public function createSources(Request $request)
    {
        $source = Source::where('id', $request->id)->first();

        Source::create([
                // 'source_code'     => $request->source_code,
                'source_name'         => $request->source_name, 
            ]);
        
        return redirect('param/source');
    }

    public function updateSources(Request $request) 
    {
        $source = Source::where('id', $request->source_id)->first();

        // dd($source);

        $source->update([
            // 'source_code'     => $request->source_code,
            'source_name'    => $request->source_name,
        ]);
        
        return redirect('param/source');
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
    public function edit()
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
        $exist = Source::find($id);
        $exist->delete();
        return response()->json(['success'=>'Source deleted successfully.']);
    }
}

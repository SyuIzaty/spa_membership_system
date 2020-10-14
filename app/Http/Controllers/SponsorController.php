<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSponsorRequest;
use App\Sponsor;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('param.sponsor.index');
    }

    public function data_sponsor()
    {
        $sponsor = Sponsor::all();

        return datatables()::of($sponsor)

           ->addColumn('action', function ($sponsor) {
               return '
               <a href="/param/sponsor/'.$sponsor->id.'/edit" class="btn btn-sm btn-primary"> Edit</a>
               <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/param/sponsor/' . $sponsor->id . '"> Delete</button>'
               ;
           })
           ->rawColumns(['action'])
           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('param.sponsor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSponsorRequest $request)
    {
        Sponsor::create($request->all());
        return redirect()->back()->with('message', 'Sponsor have been added');
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
        $sponsor = Sponsor::find($id);
        return view('param.sponsor.edit',compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSponsorRequest $request, $id)
    {
        Sponsor::find($id)->update($request->all());

        return redirect()->back()->with('message', 'Sponsor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exist = Sponsor::find($id);
        $exist->delete();
        return response()->json(['success'=>'Sponsor deleted successfully.']);
    }
}

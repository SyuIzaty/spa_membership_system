<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlatGanti;
use App\AlatanPembaikan;
use Session;

class AlatGantiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alat = new AlatGanti();
        return view('alat-ganti.index', compact('alat'));
    }

    public function data_alat()
    {
        $alat = AlatGanti::all();

        return datatables()::of($alat)
        ->addColumn('action', function ($alat) {

            $exist = AlatanPembaikan::where('alat_ganti', $alat->id)->first();

            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$alat->id.'" data-alat="'.$alat->alat_ganti.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'.$alat->id.'" data-alat="'.$alat->alat_ganti.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/alat-ganti/' . $alat->id . '"><i class="fal fa-trash"></i></button>';
            }
            
        })
            
        ->make(true);
    }

    public function tambahAlat(Request $request)
    {
        $alat = AlatGanti::where('id', $request->id)->first();

        $request->validate([
            'alat_ganti'      => 'required|max:255',
        ]);

        AlatGanti::create([
                'alat_ganti'     => $request->alat_ganti,
            ]);
        
        Session::flash('message', 'Data Alat Ganti Berjaya Ditambah');
        return redirect('alat-ganti');
    }

    public function kemaskiniALat(Request $request) 
    {
        $alat = AlatGanti::where('id', $request->alat_id)->first();

        $request->validate([
            'alat_ganti'       => 'required|max:255',
        ]);
        
        $alat->update([
            'alat_ganti'     => $request->alat_ganti,
        ]);
        
        Session::flash('notification', 'Data Alat Ganti Berjaya Dikemaskini');
        return redirect('alat-ganti');
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
        $exist = AlatGanti::find($id);
        $exist->delete();
        return response()->json(['success'=>'Data Alat Ganti Berjaya Dipadam.']);
    }
}

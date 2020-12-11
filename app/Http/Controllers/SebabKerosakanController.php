<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSebabRequest;
use Illuminate\Http\Request;
use App\KategoriAduan;
use App\SebabKerosakan;
use Session;

class SebabKerosakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sebab = SebabKerosakan::where('id', $request->id)->first();
        $kategori = KategoriAduan::all();

        return view('sebab-kerosakan.index', compact('sebab', 'kategori'));
    }

    public function data_sebab()
    {
        $sebab = SebabKerosakan::all();

        return datatables()::of($sebab)
        ->addColumn('action', function ($sebab) {

            return '
            <a href="" data-target="#crud-modals" data-toggle="modal" data-sebab="'.$sebab->id.'" data-kategori="'.$sebab->kategori_aduan.'" data-kerosakan="'.$sebab->sebab_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/sebab-kerosakan/' . $sebab->id . '"><i class="fal fa-trash"></i>  Padam</button>'
            ;
        })

        ->editColumn('kategori_aduan', function ($sebab) {

            return $sebab->kategori->nama_kategori;
       })
            
        ->make(true);
    }

    public function tambahSebab(StoreSebabRequest $request)
    {
        $sebab = SebabKerosakan::where('id', $request->id)->first();

        SebabKerosakan::create([
                'kategori_aduan'     => $request->kategori_aduan,
                'sebab_kerosakan'    => $request->sebab_kerosakan, 
            ]);
        
        Session::flash('message', 'Data Sebab Kerosakan Berjaya Ditambah');
        return redirect('sebab-kerosakan');
    }

    public function kemaskiniSebab(StoreSebabRequest $request) 
    {
        $sebab = SebabKerosakan::where('id', $request->sebab_id)->first();
        
        $sebab->update([
            'kategori_aduan'     => $request->kategori_aduan,
            'sebab_kerosakan'    => $request->sebab_kerosakan, 
        ]);
        
        Session::flash('notification', 'Data Sebab Kerosakan Berjaya Dikemaskini');
        return redirect('sebab-kerosakan');
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
        $exist = SebabKerosakan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Data Sebab Kerosakan Berjaya Dipadam.']);
    }
}

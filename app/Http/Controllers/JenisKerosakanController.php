<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KategoriAduan;
use App\JenisKerosakan;
use Session;

class JenisKerosakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jenis = JenisKerosakan::where('id', $request->id)->first();
        $kategori = KategoriAduan::all();

        return view('jenis-kerosakan.index', compact('jenis', 'kategori'));
    }

    public function data_jenis()
    {
        $jenis = JenisKerosakan::all();

        return datatables()::of($jenis)
        ->addColumn('action', function ($jenis) {

            return '
            <a href="" data-target="#crud-modals" data-toggle="modal" data-jenis="'.$jenis->id.'" data-kategori="'.$jenis->kategori_aduan.'" data-kerosakan="'.$jenis->jenis_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/jenis-kerosakan/' . $jenis->id . '"><i class="fal fa-trash"></i></button>'
            ;
        })

        ->editColumn('kategori_aduan', function ($jenis) {

            return $jenis->kategori->nama_kategori;
       })
            
        ->make(true);
    }

    public function tambahJenis(Request $request)
    {
        $jenis = JenisKerosakan::where('id', $request->id)->first();

        $request->validate([
            'kategori_aduan'       => 'required',
            'jenis_kerosakan'      => 'required|max:255',
        ]);

        JenisKerosakan::create([
                'kategori_aduan'     => $request->kategori_aduan,
                'jenis_kerosakan'    => $request->jenis_kerosakan, 
            ]);
        
        Session::flash('message', 'Data Jenis Kerosakan Berjaya Ditambah');
        return redirect('jenis-kerosakan');
    }

    public function kemaskiniJenis(Request $request) 
    {
        $jenis = JenisKerosakan::where('id', $request->jenis_id)->first();
        
        $request->validate([
            'jenis_kerosakan'      => 'required|max:255',
        ]);

        $jenis->update([
            // 'kategori_aduan'     => $request->kategori_aduan,
            'jenis_kerosakan'    => $request->jenis_kerosakan, 
        ]);
        
        Session::flash('notification', 'Data Jenis Kerosakan Berjaya Dikemaskini');
        return redirect('jenis-kerosakan');
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
        $exist = JenisKerosakan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Data Jenis Kerosakan Berjaya Dipadam.']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use Illuminate\Http\Request;
use App\KategoriAduan;
use Session;

class KategoriAduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $kategori = KategoriAduan::where('id', $request->id)->first();

        return view('kategori-aduan.index', compact('kategori'));
    }

    public function data_kategori()
    {
        $kategori = KategoriAduan::all();

        return datatables()::of($kategori)
        ->addColumn('action', function ($kategori) {

            return '
            <a href="" data-target="#crud-modals" data-toggle="modal" data-kategori="'.$kategori->id.'" data-nama="'.$kategori->nama_kategori.'" data-kod="'.$kategori->kod_kategori.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Edit</a>
            <button class="btn btn-sm btn-danger btn-delete" data-remote="/kategori-aduan/' . $kategori->id . '"><i class="fal fa-trash"></i>  Padam</button>'
            ;
        })
            
        ->make(true);
    }

    public function tambahKategori(StoreKategoriRequest $request)
    {
        $kategori = KategoriAduan::where('id', $request->id)->first();

        KategoriAduan::create([
                'kod_kategori'     => $request->kod_kategori,
                'nama_kategori'    => $request->nama_kategori, 
            ]);
        
        Session::flash('message', 'Data Kategori Berjaya Ditambah');
        return redirect('kategori-aduan');
    }

    public function kemaskiniKategori(StoreKategoriRequest $request) 
    {
        $kategori = KategoriAduan::where('id', $request->kategori_id)->first();
        // dd($kategori);
        $kategori->update([
            'kod_kategori'     => $request->kod_kategori,
            'nama_kategori'    => $request->nama_kategori, 
        ]);
        
        Session::flash('notification', 'Data Kategori Berjaya Dikemaskini');
        return redirect('kategori-aduan');
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
        $exist = KategoriAduan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Data Kategori Aduan Berjaya Dipadam.']);
    }
}

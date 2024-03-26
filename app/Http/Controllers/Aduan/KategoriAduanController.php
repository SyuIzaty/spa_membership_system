<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriAduan;
use App\JenisKerosakan;
use App\SebabKerosakan;
use App\AduanLog;
use App\Aduan;
use Session;
use Auth;

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

        return view('aduan.kategori-aduan.index', compact('kategori'));
    }

    public function dataKategori()
    {
        $kategori = KategoriAduan::whereNotIn('id', [9,10,14,16])->select('cms_kategori_aduan.*');

        return datatables()::of($kategori)

        ->addColumn('action', function ($kategori) {

            $exist = Aduan::where('kategori_aduan', $kategori->kod_kategori)->first();

            if(isset($exist)) {

                return '
                <a href="" data-target="#crud-modals" data-toggle="modal" data-kategori="'.$kategori->id.'" data-nama="'.$kategori->nama_kategori.'" data-kod="'.$kategori->kod_kategori.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '
                <a href="" data-target="#crud-modals" data-toggle="modal" data-kategori="'.$kategori->id.'" data-nama="'.$kategori->nama_kategori.'" data-kod="'.$kategori->kod_kategori.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/kategori-aduan/' . $kategori->id . '"><i class="fal fa-trash"></i></button>';
            }
        })

        ->make(true);
    }

    public function tambahKategori(Request $request)
    {
        $request->validate([
            'kod_kategori'       => 'required',
            'nama_kategori'      => 'required|max:255',
        ]);

        $kategori = KategoriAduan::create([
            'kod_kategori'     => $request->kod_kategori,
            'nama_kategori'    => $request->nama_kategori,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Tambah Kategori Aduan',
            'subject_id'        => $kategori->id,
            'subject_type'      => 'App\KategoriAduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Kategori Aduan Berjaya Ditambah');

        return redirect()->back();
    }

    public function kemaskiniKategori(Request $request)
    {
        $request->validate([
            'nama_kategori'      => 'required|max:255',
        ]);

        $kategori = KategoriAduan::where('id', $request->kategori_id)->first();

        $kategori->update([
            'nama_kategori'    => $request->nama_kategori,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Kemaskini Kategori Aduan',
            'subject_id'        => $kategori->id,
            'subject_type'      => 'App\KategoriAduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Kategori Aduan Berjaya Dikemaskini');

        return redirect()->back();
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
        $exist = KategoriAduan::where('id', $id)->first();

        $jenis = JenisKerosakan::where('kategori_aduan', $exist->kod_kategori)->delete();

        $sebab = SebabKerosakan::where('kategori_aduan', $exist->kod_kategori)->delete();

        $exist->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Padam Kategori Aduan',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\KategoriAduan',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['message'=>'Data Kategori Aduan Berjaya Dipadam.']);
    }
}

<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriAduan;
use App\JenisKerosakan;
use App\AduanLog;
use App\Aduan;
use Session;
use Auth;

class JenisKerosakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = KategoriAduan::all();

        return view('aduan.jenis-kerosakan.index', compact('kategori'));
    }

    public function dataJenis()
    {
        $jenis = JenisKerosakan::whereNotIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->with(['kategori'])->select('cms_jenis_kerosakan.*');

        return datatables()::of($jenis)

        ->addColumn('action', function ($jenis) {

            $exist = Aduan::where('jenis_kerosakan', $jenis->id)->first();

            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-jenis="'.$jenis->id.'" data-kategori="'.$jenis->kategori_aduan.'" data-kerosakan="'.$jenis->jenis_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-jenis="'.$jenis->id.'" data-kategori="'.$jenis->kategori_aduan.'" data-kerosakan="'.$jenis->jenis_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/jenis-kerosakan/' . $jenis->id . '"><i class="fal fa-trash"></i></button>';
            }

        })

        ->editColumn('kategori_aduan', function ($jenis) {

            return $jenis->kategori->nama_kategori;
       })

        ->make(true);
    }

    public function tambahJenis(Request $request)
    {
        $request->validate([
            'kategori_aduan'       => 'required',
            'jenis_kerosakan'      => 'required|max:255',
        ]);

        $jenis = JenisKerosakan::create([
            'kategori_aduan'     => $request->kategori_aduan,
            'jenis_kerosakan'    => $request->jenis_kerosakan,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Tambah Jenis Kerosakan',
            'subject_id'        => $jenis->id,
            'subject_type'      => 'App\JenisKerosakan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Jenis Kerosakan Berjaya Ditambah');

        return redirect()->back();
    }

    public function kemaskiniJenis(Request $request)
    {
        $jenis = JenisKerosakan::where('id', $request->jenis_id)->first();

        $request->validate([
            'jenis_kerosakan'      => 'required|max:255',
        ]);

        $jenis->update([
            'jenis_kerosakan'    => $request->jenis_kerosakan,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Kemaskini Jenis Kerosakan',
            'subject_id'        => $jenis->id,
            'subject_type'      => 'App\JenisKerosakan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Jenis Kerosakan Berjaya Dikemaskini');

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
        $exist = JenisKerosakan::find($id);

        $exist->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Padam Jenis Kerosakan',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\JenisKerosakan',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['message'=>'Data Jenis Kerosakan Berjaya Dipadam.']);
    }
}

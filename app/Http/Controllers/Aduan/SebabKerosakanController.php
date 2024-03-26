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

class SebabKerosakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kategori = KategoriAduan::all();

        return view('aduan.sebab-kerosakan.index', compact('kategori'));
    }

    public function cariJenis(Request $request)
    {
        $data = JenisKerosakan::select('jenis_kerosakan', 'id')
                ->where('kategori_aduan', $request->id)
                ->get();

        return response()->json($data);
    }

    public function dataSebab()
    {
        $sebab = SebabKerosakan::whereNotIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->with(['kategori'])->select('cms_sebab_kerosakan.*');

        return datatables()::of($sebab)

        ->addColumn('action', function ($sebab) {

            $exist = Aduan::where('sebab_kerosakan', $sebab->id)->first();

            if(isset($exist)) {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-sebab="'.$sebab->id.'" data-kategori="'.$sebab->kategori_aduan.'" data-kerosakan="'.$sebab->sebab_kerosakan.'" data-jenis="'.$sebab->jenis_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>';

            } else {

                return '<a href="" data-target="#crud-modals" data-toggle="modal" data-sebab="'.$sebab->id.'" data-kategori="'.$sebab->kategori_aduan.'" data-kerosakan="'.$sebab->sebab_kerosakan.'" data-jenis="'.$sebab->jenis_kerosakan.'" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i></a>
                <button class="btn btn-sm btn-danger btn-delete" data-remote="/sebab-kerosakan/' . $sebab->id . '"><i class="fal fa-trash"></i></button>';
            }

        })

        ->editColumn('kategori_aduan', function ($sebab) {

            return $sebab->kategori->nama_kategori;
        })

        ->make(true);
    }

    public function tambahSebab(Request $request)
    {
        $request->validate([
            'kategori_aduan'       => 'required',
            'sebab_kerosakan'      => 'required|max:255',
        ]);

        $sebab = SebabKerosakan::create([
            'kategori_aduan'     => $request->kategori_aduan,
            'sebab_kerosakan'    => $request->sebab_kerosakan,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Tambah Sebab Kerosakan',
            'subject_id'        => $sebab->id,
            'subject_type'      => 'App\SebabKerosakan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Sebab Kerosakan Berjaya Ditambah');

        return redirect()->back();
    }

    public function kemaskiniSebab(Request $request)
    {
        $sebab = SebabKerosakan::where('id', $request->sebab_id)->first();

        $request->validate([
            'sebab_kerosakan'       => 'required|max:255',
        ]);

        $sebab->update([
            'sebab_kerosakan'    => $request->sebab_kerosakan,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Kemaskini Sebab Kerosakan',
            'subject_id'        => $sebab->id,
            'subject_type'      => 'App\SebabKerosakan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Sebab Kerosakan Berjaya Dikemaskini');

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
        $exist = SebabKerosakan::find($id);

        $exist->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Padam Sebab Kerosakan',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\SebabKerosakan',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['message'=>'Data Sebab Kerosakan Berjaya Dipadam.']);
    }
}

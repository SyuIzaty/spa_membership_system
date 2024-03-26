<?php

namespace App\Http\Controllers\Aduan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AduanLog;
use App\AlatGanti;
use App\AlatanPembaikan;
use Session;
use Auth;

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

        return view('aduan.alat-ganti.index', compact('alat'));
    }

    public function dataAlat()
    {
        $alat = AlatGanti::select('cms_alat_ganti.*');

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
        $request->validate([
            'alat_ganti'      => 'required|max:255',
        ]);

        $alat = AlatGanti::create([
            'alat_ganti'     => $request->alat_ganti,
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Tambah Alat Ganti/Bahan',
            'subject_id'        => $alat->id,
            'subject_type'      => 'App\AlatGanti',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Alat Ganti Berjaya Ditambah');

        return redirect()->back();
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

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Kemaskini Alat Ganti/Bahan',
            'subject_id'        => $alat->id,
            'subject_type'      => 'App\AlatGanti',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Data Alat Ganti Berjaya Dikemaskini');

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
        $exist = AlatGanti::find($id);

        $exist->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'Padam Alat Ganti/Bahan',
            'subject_id'        => $exist->id,
            'subject_type'      => 'App\AlatGanti',
            'properties'        => json_encode($exist),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return response()->json(['message'=>'Data Alat Ganti Berjaya Dipadam.']);
    }
}

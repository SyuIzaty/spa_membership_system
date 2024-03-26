<?php

namespace App\Http\Controllers\HelpdeskIT;

use Auth;
use DB;
use App\User;
use App\Staff;
use App\Aduan;
use Session;
use App\AlatGanti;
use App\ResitAduan;
use App\ImejAduan;
use App\KategoriAduan;
use App\StatusAduan;
use App\StokPembaikan;
use App\TahapKategori;
use App\ImejPembaikan;
use App\AlatanPembaikan;
use App\JuruteknikBertugas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Exports\HelpdeskIT\eAduanITExport;

class EAduanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function aduanIT()
    {
        $senarai_bulan_tahun = Aduan::select(DB::raw('MONTH(tarikh_laporan) as month'), DB::raw('YEAR(tarikh_laporan) as year'))
                ->groupBy(DB::raw('MONTH(tarikh_laporan)'), DB::raw('YEAR(tarikh_laporan)'))->orderBy(DB::raw('YEAR(tarikh_laporan)'), 'ASC')
                ->orderBy(DB::raw('MONTH(tarikh_laporan)'), 'ASC')->get();

        $senarai_bulan = $senarai_bulan_tahun->pluck('month')->unique()->sort();

        $senarai_tahun = $senarai_bulan_tahun->pluck('year')->unique()->sort();

        $senarai_kategori = KategoriAduan::whereIn('kod_kategori', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->get();

        $senarai_status = StatusAduan::all();

        $senarai_tahap = TahapKategori::all();

        $juruteknik = JuruteknikBertugas::whereHas('aduan', function($query){
            $query->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS']);
        })->distinct('juruteknik_bertugas')->pluck('juruteknik_bertugas')->toArray();

        $senarai_juruteknik = Staff::whereIn('staff_id', $juruteknik)->whereIn('staff_code', ['IITU'])->get();

        return view('helpdesk-it.aduan-it', compact('senarai_bulan','senarai_tahun', 'senarai_kategori',
        'senarai_status', 'senarai_tahap','senarai_juruteknik'));
    }

    public function dataAduanIT(Request $request)
    {
        $tahun = $request->input('tahun');

        $bulan = $request->input('bulan');

        $kategori = $request->input('kategori');

        $jenis = $request->input('jenis');

        $sebab = $request->input('sebab');

        $status = (array) $request->input('status');

        $tahap = $request->input('tahap');

        $kategoriPengadu = $request->input('kategoriPengadu');

        $pengadu = $request->input('pengadu');

        $juruteknik = $request->input('juruteknik');

        $data = Aduan::
            when($tahun, function ($query) use ($tahun) {
                $query->whereYear('tarikh_laporan', $tahun);
            })
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('tarikh_laporan', $bulan);
            })
            ->when($kategori, function ($query) use ($kategori) {
                if ($kategori != 'null' && $kategori != '') {

                    $query->where('kategori_aduan', $kategori);

                } else {

                    $query->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS']);
                }
            })
            ->when($jenis, function ($query) use ($jenis) {
                $query->where('jenis_kerosakan', $jenis);
            })
            ->when($sebab, function ($query) use ($sebab) {
                $query->where('sebab_kerosakan', $sebab);
            })
            ->when($tahap, function ($query) use ($tahap) {
                $query->where('tahap_kategori', $tahap);
            })
            ->when($status, function ($query) use ($status) {
                $query->whereIn('status_aduan', $status);
            })
            ->when($kategoriPengadu, function ($query) use ($kategoriPengadu) {
                if ($kategoriPengadu == 'STF') {

                    $staffIds = User::select('id')->where('category', 'STF')->pluck('id')->toArray();

                    $query->whereIn('id_pelapor', $staffIds)->whereNull('deleted_at');

                } elseif ($kategoriPengadu == 'STD') {

                    $studentIds = User::select('id')->where('category', 'STD')->pluck('id')->toArray();

                    $query->whereIn('id_pelapor', $studentIds)->whereNull('deleted_at');
                }
            })
            ->when($pengadu, function ($query) use ($pengadu) {
                $query->where('id_pelapor', $pengadu);
            })
            ->when($juruteknik, function ($query) use ($juruteknik) {
                $query->whereHas('juruteknik', function ($query) use ($juruteknik) {
                    $query->where('juruteknik_bertugas', $juruteknik);
                });
            })
        ->whereNotIn('status_aduan', ['AB'])
        ->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])
        ->with(['kategori', 'jenis', 'sebab', 'tahap', 'status','pengadu'])
        ->select('cms_aduan.*');

        return datatables()::of($data)

        ->addColumn('action', function ($data) {

            return '<div class="btn-group"><a href="/info-aduan-it/' . $data->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('kategori_aduan', function ($data) {

            return isset($data->kategori->nama_kategori) ? strtoupper($data->kategori->nama_kategori) : '<div style="color:red;">--</div>';
        })

        ->editColumn('tahap_kategori', function ($data) {

            return isset($data->tahap->jenis_tahap) ? strtoupper($data->tahap->jenis_tahap) : '<div style="color:red;">--</div>';
        })

        ->addColumn('tarikh_laporan', function ($data) {

            return isset($data->tarikh_laporan) ? date('d/m/Y', strtotime($data->tarikh_laporan)) : '<div style="color:red;">--</div>';
        })

        ->addColumn('tarikh_selesai_aduan', function ($data) {

            return isset($data->tarikh_selesai_aduan) ? date('d/m/Y', strtotime($data->tarikh_selesai_aduan)) : '<div style="color:red;">--</div>';
        })

        ->editColumn('status_aduan', function ($data) {

            return isset($data->status->nama_status) ? strtoupper($data->status->nama_status) : '<div style="color:red;">--</div>';
        })

        ->rawColumns(['kategori_aduan', 'tahap_kategori', 'tarikh_laporan', 'tarikh_selesai_aduan', 'status_aduan', 'action'])

        ->make(true);
    }

    public function laporanAduanIT($params)
    {
        $paramArray = explode('/', $params);

        $tahun = $paramArray[0] ?? null;

        $bulan = $paramArray[1] ?? null;

        $kategori = $paramArray[2] ?? null;

        $jenis = $paramArray[3] ?? null;

        $sebab = $paramArray[4] ?? null;

        $status = isset($paramArray[5]) ? explode(',', $paramArray[5]) : null;

        $tahap = $paramArray[6] ?? null;

        $kategoriPengadu = $paramArray[7] ?? null;

        $pengadu = $paramArray[8] ?? null;

        $juruteknik = $paramArray[9] ?? null;

        return Excel::download(
            new eAduanITExport($tahun, $bulan, $kategori, $jenis, $sebab, $status, $tahap, $kategoriPengadu, $pengadu, $juruteknik),
            'Laporan Aduan IT.xlsx'
        );
    }

    public function infoAduanIT($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $tahap = TahapKategori::all();

        $status = StatusAduan::all();

        $juruteknik = User::whereIn('id', ['16020232', '20020451', '22020495'])->get();

        $juruteknik_bertugas = JuruteknikBertugas::where('id_aduan', $aduan->id)->get();

        $resit = ResitAduan::where('id_aduan', $aduan->id)->get();

        $imej = ImejAduan::where('id_aduan', $aduan->id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $aduan->id)->get();

        $alatan = AlatGanti::orderBy('alat_ganti')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $aduan->id)->get();

        $stok_pembaikan = StokPembaikan::where('id_aduan', $aduan->id)->get();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('helpdesk-it.info-aduan-it', compact('aduan', 'tahap', 'status', 'juruteknik', 'juruteknik_bertugas', 'resit', 'imej',
        'gambar', 'alatan', 'alatan_ganti', 'stok_pembaikan', 'pengadu'));
    }

    public function simpanPembaikanIT(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'tarikh_serahan_aduan'   => $request->tarikh_serahan_aduan,
            'tahap_kategori'         => $request->tahap_kategori,
            'caj_kerosakan'          => $request->caj_kerosakan,
            'tarikh_selesai_aduan'   => $request->tarikh_selesai_aduan,
            'laporan_pembaikan'      => $request->laporan_pembaikan,
            'ak_upah'                => $request->ak_upah,
            'ak_bahan_alat'          => $request->ak_bahan_alat,
            'jumlah_kos'             => $request->jumlah_kos,
            'status_aduan'           => $request->status_aduan,
            'catatan_pembaikan'      => $request->catatan_pembaikan,
        ]);

        if (isset($request->juruteknik_bertugas)) {

            $juruteknikBaru = collect($request->juruteknik_bertugas);

            $juruteknikTerkini = JuruteknikBertugas::where('id_aduan', $aduan->id)->pluck('juruteknik_bertugas');

            $juruteknikTambah = $juruteknikBaru->diff($juruteknikTerkini);

            $juruteknikPadam = $juruteknikTerkini->diff($juruteknikBaru);

            $index = 0;

            $juruteknikTambah->each(function ($value) use ($aduan, &$index) {
                JuruteknikBertugas::create([
                    'id_aduan'              => $aduan->id,
                    'juruteknik_bertugas'   => $value,
                    'jenis_juruteknik'      => $index == 0 ? 'K' : 'P',
                ]);
                $index++;
            });

            JuruteknikBertugas::where('id_aduan', $aduan->id)
                ->whereIn('juruteknik_bertugas', $juruteknikPadam)
                ->delete();
        }

        if (isset($request->bahan_alat)) {

            $alatBaru = collect($request->bahan_alat);

            $alatTerkini = AlatanPembaikan::where('id_aduan', $aduan->id)->pluck('alat_ganti');

            $alatTambah = $alatBaru->diff($alatTerkini);

            $alatPadam = $alatTerkini->diff($alatBaru);

            $index = 0;

            $alatTambah->each(function ($value) use ($aduan, &$index) {
                AlatanPembaikan::create([
                    'id_aduan'     => $aduan->id,
                    'alat_ganti'   => $value,
                ]);
                $index++;
            });

            AlatanPembaikan::where('id_aduan', $aduan->id)
                ->whereIn('alat_ganti', $alatPadam)
                ->delete();
        }

        if (isset($request->upload_image)) {

            $image = $request->upload_image;

            $paths = storage_path()."/pembaikan/";

            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();

                $fileSizes = $image[$y]->getSize();

                $fileNames = $originalsName;

                $image[$y]->storeAs('/pembaikan', date('dmyhi').' - '.$fileNames);

                ImejPembaikan::create([
                    'id_aduan'      => $aduan->id,
                    'upload_image'  => date('dmyhi').' - '.$originalsName,
                    'web_path'      => "app/pembaikan/".date('dmyhi').' - '.$fileNames,
                ]);
            }
        }

        Session::flash('message', 'Borang pembaikan telah dikemaskini.');

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
        //
    }
}

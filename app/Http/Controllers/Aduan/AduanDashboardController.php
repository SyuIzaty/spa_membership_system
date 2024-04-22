<?php

namespace App\Http\Controllers\Aduan;

use DB;
use App\Staff;
use App\User;
use App\Aduan;
use Carbon\Carbon;
use App\KategoriAduan;
use App\StatusAduan;
use App\TahapKategori;
use App\JuruteknikBertugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AduanDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index(Request $request)
    {
        $aduan = Aduan::whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->whereNotIn('status_aduan', ['AB'])->get();

        $senarai_bulan_tahun = Aduan::select(DB::raw('MONTH(tarikh_laporan) as month'), DB::raw('YEAR(tarikh_laporan) as year'))
                ->groupBy(DB::raw('MONTH(tarikh_laporan)'), DB::raw('YEAR(tarikh_laporan)'))->orderBy(DB::raw('YEAR(tarikh_laporan)'), 'ASC')
                ->orderBy(DB::raw('MONTH(tarikh_laporan)'), 'ASC')->get();

        $senarai_bulan = $senarai_bulan_tahun->pluck('month')->unique()->sort();

        $senarai_tahun = $senarai_bulan_tahun->pluck('year')->unique()->sort();

        $senarai_kategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();

        $senarai_status = StatusAduan::all();

        $senarai_tahap = TahapKategori::all();

        $juruteknik = JuruteknikBertugas::whereHas('aduan', function($query){
            $query->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM']);
        })->distinct('juruteknik_bertugas')->pluck('juruteknik_bertugas')->toArray();

        $senarai_juruteknik = Staff::whereIn('staff_id', $juruteknik)->whereIn('staff_code', ['OFM', 'AA'])->get();

        return view('aduan.dashboard', compact('aduan','senarai_bulan','senarai_tahun','senarai_kategori','senarai_status','senarai_tahap','senarai_juruteknik'));
    }

    public function kemaskiniAduanRingkasan(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $kategori = $request->input('kategori');
        $jenis = $request->input('jenis');
        $sebab = $request->input('sebab');
        $tahap = $request->input('tahap');
        $kategoriPengadu = $request->input('kategoriPengadu');
        $juruteknik = $request->input('juruteknik');
        $status = $request->input('status');

        $query = Aduan::
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

                    $query->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM']);
                }
            })

            ->when($jenis, function ($query) use ($jenis) {
                $query->whereIn('jenis_kerosakan', $jenis);
            })

            ->when($sebab, function ($query) use ($sebab) {
                $query->whereIn('sebab_kerosakan', $sebab);
            })

            ->when($tahap, function ($query) use ($tahap) {
                $query->where('tahap_kategori', $tahap);
            })

            ->when($status, function ($query) use ($status) {
                if ($status != 'null' && $status != '') {

                    $query->whereIn('status_aduan', $status)->whereNotIn('status_aduan', ['AB']);

                } else {

                    $query->whereNotIn('status_aduan', ['AB']);
                }
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

            ->when($juruteknik, function ($query) use ($juruteknik) {

                if ($juruteknik != 'null' && $juruteknik != '') {

                    $query->whereHas('stafJuruteknik', function ($query) use ($juruteknik) {
                        $query->where('juruteknik_bertugas', $juruteknik)->whereNull('deleted_at');
                    });

                } else {

                    $juruteknik_terkumpul = JuruteknikBertugas::whereHas('aduan', function ($query) {
                        $query->whereIn('kategori_aduan', ['AWM', 'ELK', 'MKL', 'PKH', 'TKM']);
                    })->distinct('juruteknik_bertugas')->pluck('juruteknik_bertugas')->toArray();

                    $query->whereHas('stafJuruteknik', function ($query) use ($juruteknik_terkumpul) {
                        $query->whereIn('juruteknik_bertugas', $juruteknik_terkumpul)->whereNull('deleted_at');
                    });
                }
            })

        ->whereNull('deleted_at')->get();

        $data = $query;

        $kategoriData = '<tr class="text-center">';

        $kategoriData .= '<th class="bg-primary-50">STATUS \ KATEGORI</th>';

        if (isset($kategori)) {

            $senaraiKategori = KategoriAduan::where('kod_kategori', $kategori)->get();

            foreach ($senaraiKategori as $column) {
                $kategoriData .= '<th style="background-color: #ece5f7; color: rgba(0, 0, 0, .8)">' . $column->nama_kategori . '</th>';
            }
        } else {
            $semuaKategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();

            foreach ($semuaKategori as $column) {
                $kategoriData .= '<th style="background-color: #ece5f7; color: rgba(0, 0, 0, .8)">' . $column->nama_kategori . '</th>';
            }
        }

        $kategoriData .= '<th style="background-color: #fbeaf2; color: rgba(0, 0, 0, .8)"><b>JUMLAH</b></th>';

        $kategoriData .= '</tr>';

        if (isset($status)) {
            $senaraiStatus = StatusAduan::where('kod_status', $status)->whereNotIn('kod_status', ['AB'])->get();

        } else {
            $senaraiStatus = StatusAduan::whereNotIn('kod_status', ['AB'])->get();
        }

        $aduanData = '';

        foreach ($senaraiStatus as $row) {

                $aduanData .= '<tr class="text-center">';
                $aduanData .= '<td class="text-left" style="background-color: #ece5f7; color: rgba(0, 0, 0, .8)"><b>' . $row->kod_status .' - '. strtoupper($row->nama_status) . '</b></td>';

                $jumlahAduan = 0;

                if (isset($kategori)) {
                    $senaraiKategori = KategoriAduan::where('kod_kategori', $kategori)->get();
                } else {
                    $senaraiKategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();
                }

                foreach ($senaraiKategori as $column) {

                    $kiraanAduan = $data->where('status_aduan', $row->kod_status)->where('kategori_aduan', $column->kod_kategori)->count();

                    $jumlahAduan += $kiraanAduan;

                    if (!isset($jumlahKategori[$column->kod_kategori])) {
                        $jumlahKategori[$column->kod_kategori] = 0;
                    }
                    $jumlahKategori[$column->kod_kategori] += $kiraanAduan;

                    $aduanData .= '<td>' . $kiraanAduan . '</td>';
                }

            $aduanData .= '<td style="background-color: #fbeaf2; color: rgba(0, 0, 0, .8)">' . $jumlahAduan . '</td>';
            $aduanData .= '</tr>';
        }

        $jumlahData = '<tr class="text-center">';

        $jumlahData .= '<td style="background-color: #fbeaf2; color: rgba(0, 0, 0, .8)"><b> JUMLAH </b></td>';

        foreach ($jumlahKategori as $total) {
            $jumlahData .= '<td style="background-color: #fbeaf2; color: rgba(0, 0, 0, .8)">' . $total . '</td>';
        }

        $jumlahKeseluruhan = array_sum($jumlahKategori);

        $jumlahData .= '<td class="bg-danger-50"><b>' . $jumlahKeseluruhan . '</b></td>';

        $jumlahData .= '</tr>';

        return response()->json(['kategoriData' => $kategoriData, 'aduanData' => $aduanData, 'jumlahData' => $jumlahData]);
    }

    public function kemaskiniAduanJuruteknik(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        $kategori = $request->input('kategori');
        $jenis = $request->input('jenis');
        $sebab = $request->input('sebab');
        $tahap = $request->input('tahap');
        $kategoriPengadu = $request->input('kategoriPengadu');
        $juruteknik = $request->input('juruteknik');
        $status = $request->input('status');

        $query = Aduan::
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

                    $query->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM']);
                }
            })

            ->when($jenis, function ($query) use ($jenis) {
                $query->whereIn('jenis_kerosakan', $jenis);
            })

            ->when($sebab, function ($query) use ($sebab) {
                $query->whereIn('sebab_kerosakan', $sebab);
            })

            ->when($tahap, function ($query) use ($tahap) {
                $query->where('tahap_kategori', $tahap);
            })

            ->when($status, function ($query) use ($status) {
                if ($status != 'null' && $status != '') {

                    $query->whereIn('status_aduan', $status)->whereNotIn('status_aduan', ['AB']);

                } else {

                    $query->whereNotIn('status_aduan', ['AB']);
                }
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

            ->when($juruteknik, function ($query) use ($juruteknik) {

                if ($juruteknik != 'null' && $juruteknik != '') {

                    $query->whereHas('stafJuruteknik', function ($query) use ($juruteknik) {
                        $query->where('juruteknik_bertugas', $juruteknik)->whereNull('deleted_at');
                    });

                } else {

                    $juruteknik_terkumpul = JuruteknikBertugas::whereHas('aduan', function ($query) {
                        $query->whereIn('kategori_aduan', ['AWM', 'ELK', 'MKL', 'PKH', 'TKM']);
                    })->distinct('juruteknik_bertugas')->pluck('juruteknik_bertugas')->toArray();

                    $query->whereHas('stafJuruteknik', function ($query) use ($juruteknik_terkumpul) {
                        $query->whereIn('juruteknik_bertugas', $juruteknik_terkumpul)->whereNull('deleted_at');
                    });
                }
            })

        ->whereNull('deleted_at')->get();

        if (isset($kategori)) {
            $senarai_kategori = KategoriAduan::where('kod_kategori', $kategori)->get();
        } else {
            $senarai_kategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();
        }

        if (isset($juruteknik)) {
            $senarai_juruteknik = Staff::where('staff_id', $juruteknik)->whereNotIn('staff_code', ['IITU'])->get();
        } else {
            $kumpul_juruteknik = JuruteknikBertugas::whereHas('aduan', function ($query) {
                $query->whereIn('kategori_aduan', ['AWM', 'ELK', 'MKL', 'PKH', 'TKM']);
            })->pluck('juruteknik_bertugas')->toArray();

            $senarai_juruteknik = Staff::whereIn('staff_id', $kumpul_juruteknik)->whereNotIn('staff_code', ['IITU'])->get();
        }

        $datasets = [];

        foreach ($senarai_kategori as $key => $kategori) {

            $randomColor = $this->generateRandomLightColor();

            $data = [
                'label' => $kategori->nama_kategori,
                'data' => [],
                'backgroundColor' => $randomColor,
            ];

            foreach ($senarai_juruteknik as $juruteknik) {

                $countList = Aduan::whereHas('stafJuruteknik', function($q) use($juruteknik){
                    $q->where('juruteknik_bertugas', $juruteknik->staff_id);
                })->pluck('id')->toArray();

                $count = $query->whereIn('id', $countList)
                    ->where('kategori_aduan', $kategori->kod_kategori)
                    ->count();

                $data['data'][] = $count;
            }

            $datasets[] = $data;
        }

        $semua_juruteknik = $senarai_juruteknik->pluck('staff_name')->toArray();

        $data = [
            'labels' => $semua_juruteknik,
            'datasets' => $datasets,
        ];

        return response()->json($data);
    }

    private function generateRandomLightColor()
    {
        $red = rand(200, 255);
        $green = rand(200, 255);
        $blue = rand(200, 255);

        return "rgb($red, $green, $blue)";
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

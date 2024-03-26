<?php

namespace App\Exports\Aduan;

use App\User;
use App\Aduan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class eAduanFacilityAllExport implements FromView, WithColumnFormatting
{
    protected $tahun;
    protected $bulan;
    protected $kategori;
    protected $jenis;
    protected $sebab;
    protected $status;
    protected $tahap;
    protected $kategoriPengadu;
    protected $pengadu;
    protected $juruteknik;

    public function __construct($tahun, $bulan, $kategori, $jenis, $sebab, $status, $tahap, $kategoriPengadu, $pengadu, $juruteknik)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
        $this->kategori = $kategori;
        $this->jenis = $jenis;
        $this->sebab = $sebab;
        $this->status = (array)$status;
        $this->tahap = $tahap;
        $this->kategoriPengadu = $kategoriPengadu;
        $this->pengadu = $pengadu;
        $this->juruteknik = $juruteknik;
    }

    public function view(): View
    {
        $tahun              = $this->tahun;
        $bulan              = $this->bulan;
        $kategori           = $this->kategori;
        $jenis              = $this->jenis;
        $sebab              = $this->sebab;
        $status             = (array)$this->status;
        $tahap              = $this->tahap;
        $kategoriPengadu    = $this->kategoriPengadu;
        $pengadu            = $this->pengadu;
        $juruteknik         = $this->juruteknik;

        $data = Aduan::query();

        if ($tahun != 'null' && $tahun != '') {
            $data->whereYear('tarikh_laporan', $tahun);
        }

        if ($bulan != 'null' && $bulan != '') {
            $data->whereMonth('tarikh_laporan', $bulan);
        }

        if ($kategori != 'null' && $kategori != '') {
            $data->where('kategori_aduan', $kategori);
        }

        if ($jenis != 'null' && $jenis != '') {
            $data->where('jenis_kerosakan', $jenis);
        }

        if ($sebab != 'null' && $sebab != '') {
            $data->where('sebab_kerosakan', $sebab);
        }

        if (count(array_filter($status, function ($value) {
            return $value !== 'null' && $value !== '';
        })) != 0) {
            $data->whereIn('status_aduan', $status);
        }

        if ($tahap != 'null' && $tahap != '') {
            $data->where('tahap_kategori', $tahap);
        }

        if ($kategoriPengadu != 'null' && $kategoriPengadu != '') {
            if ($kategoriPengadu == 'STF') {

                $staffIds = User::select('id')->where('category', 'STF')->pluck('id')->toArray();

                $data->whereIn('id_pelapor', $staffIds)->whereNull('deleted_at');

            } elseif ($kategoriPengadu == 'STD') {

                $studentIds = User::select('id')->where('category', 'STD')->pluck('id')->toArray();

                $data->whereIn('id_pelapor', $studentIds)->whereNull('deleted_at');
            }
        }

        if ($pengadu != 'null' && $pengadu != '') {
            $data->where('id_pelapor', $pengadu);
        }

        if ($juruteknik != 'null' && $juruteknik != '') {
            $data->whereHas('juruteknik', function ($query) use ($juruteknik) {
                $query->where('juruteknik_bertugas', $juruteknik);
            });
        }

        $data = $data->whereNotIn('status_aduan', ['AB'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->get();

        return view('aduan.laporan-aduan-excel', compact('data'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

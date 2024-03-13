<?php

namespace App\Exports\Aduan;

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

class eAduanFacilityExport implements FromView, WithColumnFormatting
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $id = $this->id;

        $data = Aduan::where('id_pelapor', $id)->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->get();
        //after standardized can remove kategori_aduan

        return view('aduan.pengguna.laporan-excel', compact('data','id'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

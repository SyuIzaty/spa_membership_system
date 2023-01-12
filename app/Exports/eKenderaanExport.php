<?php

namespace App\Exports;

use App\eKenderaan;
use App\eKenderaanPassengers;
use App\eKenderaanAssignDriver;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class eKenderaanExport implements FromView, WithEvents, WithStyles, WithColumnFormatting
{
    public function view(): View
    {
        $data = eKenderaan::whereIn('status', ['3','5'])->with(['drivers','vehicles','passengers','areas'])->get();

        return view('eKenderaan.report-export', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
        $passenger = eKenderaanPassengers::count();

        $total = eKenderaan::whereIn('status', ['3','5'])->get()->count() + $passenger + 2;

        return [
            "A1:V{$total}" => [
                'borders' => ['allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            // T is the IC column
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $passenger = eKenderaanPassengers::count();
                $total = eKenderaan::whereIn('status', ['3','5'])->get()->count() + $passenger + 2;

                $cellAllRange = 'A1:V'.$total.'';
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('R2:V2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            // $event->sheet->getDelegate()->getStyle('N5:N'.$total.'')->getAlignment()->setWrapText(true);
            },
        ];
    }
}

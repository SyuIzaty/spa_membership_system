<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\eKenderaan;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class eKenderaanExport implements FromView, WithEvents, WithStyles
{
    public function view(): View
    {
        $data = eKenderaan::whereIn('status', ['3','5'])->get();

        return view('eKenderaan.report-export', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
        $total = eKenderaan::whereIn('status', ['3','5'])->get()->count() + 1;

        return [
            "A1:S{$total}" => [
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $total = eKenderaan::whereIn('status', ['3','5'])->get()->count() + 1;

                $cellAllRange = 'A1:SS'.$total.'';
                $event->sheet->getDelegate()->getStyle('A1:S1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            // $event->sheet->getDelegate()->getStyle('N5:N'.$total.'')->getAlignment()->setWrapText(true);
            },
        ];
    }
}

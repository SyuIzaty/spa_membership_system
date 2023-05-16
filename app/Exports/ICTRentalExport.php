<?php

namespace App\Exports;

use App\EquipmentStaff;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ICTRentalExport implements FromView, WithEvents, WithStyles, WithColumnFormatting
{
    public function view(): View
    {
        $data = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->get();

        return view('test.rent_report_export', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
        $staff = EquipmentStaff::count();

        $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])->get()->count() + $staff + 2;

        return [
            "A1:L{$total}" => [
                'borders' => ['allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
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
                $staff = EquipmentStaff::count();
                $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])->get()->count() + $staff + 2;

                $cellAllRange = 'A1:L' . $total . '';
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }
}

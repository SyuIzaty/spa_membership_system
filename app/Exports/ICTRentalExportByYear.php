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

class ICTRentalExportByYear implements FromView, WithEvents, WithStyles, WithColumnFormatting
{
    public function __construct($year)
    {
        $this->year = $year;
    }

    public function view(): View
    {
        $year = $this->year;

        $data = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->whereYear('rent_date', $year)
            ->get();

        return view('test.rent_report_export', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
        $rent = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->whereYear('rent_date', $this->year)
            ->pluck('id')->toArray();

        $staff = EquipmentStaff::whereIn('staff_id', $rent)->count();

        $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->whereYear('rent_date', $this->year)
            ->get()
            ->count() + $staff + 2;

        return [
            "A1:V{$total}" => [
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
                $rent = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])
                    ->whereYear('rent_date', $this->year)
                    ->pluck('id')->toArray();

                $staff = EquipmentStaff::whereIn('staff_id', $rent)->count();

                $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
                    ->whereYear('rent_date', $this->year)
                    ->get()
                    ->count() + $staff + 2;

                $cellAllRange = 'A1:V' . $total . '';
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('R2:V2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }

}

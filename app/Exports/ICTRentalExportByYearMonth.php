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

class ICTRentalExportByYearMonth implements FromView, WithEvents, WithStyles, WithColumnFormatting
{
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        $year = $this->year;
        $month = $this->month;
        $m = date('m', strtotime($month));

        $data = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])->whereYear('rent_date', $year)
            ->whereMonth('rent_date', $m)->get();

        return view('test.rent_report_export', compact('data'));
    }

    public function styles(Worksheet $sheet)
    {
        $month = $this->month;
        $m = date('m', strtotime($month));

        $rent = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])->whereYear('rent_date', $this->year)
            ->whereMonth('rent_date', $m)->pluck('id')->toArray();

        $staff = EquipmentStaff::whereIn('id', $rent)->count();

        $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])->whereYear('rent_date', $this->year)
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

    public function columnFormats(): array//must have? cause it can causes error when remove this fx

    {
        return [
            // T is the IC column
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    public function registerEvents(): array//returns an array of events that registered by a Laravel Excel package.

    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $month = $this->month;
                $m = date('m', strtotime($month));

                $rent = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])->whereYear('rent_date', $this->year)
                    ->whereMonth('created_at', $m)->pluck('id')->toArray();

                $staff = EquipmentStaff::whereIn('id', $rent)->count();

                $total = EquipmentStaff::whereIn('status', ['Approved', 'Rejected','Pending'])->whereYear('rent_date', $this->year)
                    ->whereMonth('created_at', $m)->get()->count() + $staff + 2;

                $cellAllRange = 'A1:V' . $total . ''; //range of cells from column A to V
                $event->sheet->getDelegate()->getStyle('A1:V1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('R2:V2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }

}

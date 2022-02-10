<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\AduanKorporat;
use App\AduanKorporatStatus;
use App\AduanKorporatCategory;
use App\AduanKorporatUser;
use App\AduanKorporatLog;
use App\AduanKorporatRemark;
use App\AduanKorporatFile;
use App\AduanKorporatAdmin;
use App\AduanKorporatDepartment;
use App\AduanKorporatSubCategory;
use App\User;
use App\Staff;
use DateTime;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class iComplaintExportByYearMonth implements FromView, WithEvents, WithStyles, WithDrawings
{
    public function __construct($year,$month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
        $year = $this->year;
        $month = $this->month;
        $m = date('m', strtotime($month));

        $list = AduanKorporat::whereMonth('created_at', $m)->whereYear('created_at', $year)->get();
        $log = AduanKorporatLog::whereMonth('created_at', $m)->whereYear('created_at', $year)->where('activity','Completed');

        return view('aduan-korporat.export-report-year-month', compact('list','log','year','month'));
    }

    public function styles(Worksheet $sheet)
    {
        $total = AduanKorporat::whereYear('created_at', $this->year)->count() + 4;
        
        return [
            "A4:O4" => [
                'borders' => ['allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            "A5:O{$total}" => [
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

    public function letterIncrement($letter,$increment)
    {
        for ($i=1; $i<$increment; $i++)
        {
            ++$letter;
        }
        return $letter;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $total = AduanKorporat::whereYear('created_at', $this->year)->count() + 4;
        
                $cellAllRange = 'A1:AA'.$total.'';
                $event->sheet->getDelegate()->getStyle('A4:O4')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
                $event->sheet->getDelegate()->getStyle('N5:N'.$total.'')->getAlignment()->setWrapText(true);
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('img/intec_logo_new.png'));
        $drawing->setHeight(70);
        $drawing->setCoordinates('C1');
        return $drawing;
    }
}

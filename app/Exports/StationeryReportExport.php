<?php

namespace App\Exports;

use App\IsmApplication;
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

class StationeryReportExport implements FromView, WithColumnFormatting
{
    protected $department;
    protected $month;
    protected $year;
    protected $status;
    protected $type;

    public function __construct($department, $month, $year, $status, $type)
    {
        $this->department = $department;
        $this->month = $month;
        $this->year = $year;
        $this->status = $status;
        $this->type = $type;
    }

    public function view(): View
    {
        $department = $this->department;
        $month = $this->month;
        $year = $this->year;
        $status = $this->status;
        $type = $this->type;

        $data = IsmApplication::query();

        if ($department != 'null') {
            $data->where('applicant_dept', $department);
        }

        if ($month != 'null') {
            $data->whereMonth('created_at', $month);
        }

        if ($year != 'null') {
            $data->whereYear('created_at', $year);
        }

        if ($status != 'null') {
            $data->where('current_status', $status);
        }

        $data = $data->get();

        return view('stationery.application-report-export', compact('data', 'type'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

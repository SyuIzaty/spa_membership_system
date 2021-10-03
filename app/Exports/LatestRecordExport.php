<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\TrainingHourTrail;
use App\TrainingHourYear;
use App\TrainingClaim;
use Carbon\Carbon;
use Auth;
use DB;

class LatestRecordExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $staff = TrainingHourTrail::where('year', Carbon::now()->format('Y'))->get();

        return $staff;
    }

    public function map($staff): array
    {
        $total_hour = TrainingHourYear::where('year', $staff->year)->first();
        $current_hours = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $staff->year )->where('staff_id', $staff->staff_id)->where('status', '2')->sum('approved_hour');

        return [
            $staff->year,
            $staff->staffs->staff_id ?? '--',
            $staff->staffs->staff_name ?? '--',
            $staff->staffs->staff_email ?? '--',
            $staff->staffs->staff_phone ?? '--',
            $staff->staffs->staff_position ?? '--',
            $staff->staffs->staff_dept ?? '--',
            $total_hour->training_hour ?? '--',
            $current_hours ?? '--',
            $staff->record_status->status_name ?? '--',
            isset($staff->created_at) ? date(' d/m/Y ', strtotime($staff->created_at) ) : '--'
        ];
    }

    public function headings(): array
    {
        return [
            'YEAR',
            'STAFF ID',
            'STAFF NAME',
            'STAFF EMAIL',
            'STAFF PHONE NO',
            'STAFF POSITION',
            'STAFF DEPARTMENT',
            'ASSIGN HOURS',
            'ACQUIRE HOURS',
            'STATUS',
            'ASSIGN DATE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = TrainingHourTrail::get()->count() + 1;
                $cellRange = 'A1:K'.$all.'';
                $head_title = 'A1:K1';
                $event->sheet->getDelegate()->getStyle($head_title)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($head_title)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F7E7E4');
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Vaccine;

class VaccineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $vaccine = Vaccine::with('reasons','staffs')->get();

        return $vaccine;
    }

    public function map($vaccine): array
    {
        
        return [
            $vaccine->user_id,
            $vaccine->staffs->staff_name ?? '--',
            $vaccine->staffs->staff_position ?? '--',
            $vaccine->staffs->staff_dept ?? '--',
            $vaccine->staffs->staff_email ?? '--',
            $vaccine->staffs->staff_phone ?? '--',
            $vaccine->q1 ?? '--',
            $vaccine->q1_reason ?? '--',
            $vaccine->q1_other_reason ?? '--',
            $vaccine->q2 ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->q3_date) ) ?? '--',
            $vaccine->q3 ?? '--',
            $vaccine->q3_reason ?? '--',
            $vaccine->q3_effect ?? '--',
            $vaccine->q3_effect_remark ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->q4_date) ) ?? '--',
            $vaccine->q4 ?? '--',
            $vaccine->q4_reason ?? '--',
            $vaccine->q4_effect ?? '--',
            $vaccine->q4_effect_remark ?? '--',
            $vaccine->q5 ?? '--',
            $vaccine->q5_appt ?? '--',
            $vaccine->q5_name ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->q5_first_dose) ) ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->q5_second_dose) ) ?? '--',
            $vaccine->q6 ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->created_at) ) ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($vaccine->updated_at) ) ?? '--',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Position',
            'Department',
            'Email',
            'Phone No.',
            'Have already registered to receive the COVID-19 vaccine ?',
            'If NO',
            'If OTHERS',
            'Have received an appointment date for the vaccine injection ?',
            'First dose appointment date',
            'Have you finished receiving your first dose vaccine ?',
            'if NO',
            'Do you receive side effects from first dose vaccine injection ?',
            'First dose side effects',
            'Second dose appointment date',
            'Have you finished receiving your second dose vaccine ?',
            'if NO',
            'Do you receive side effects from second dose vaccine injection ?',
            'Second dose side effects',
            'Do you have a spouse ?',
            'Has your spouse received a vaccination appointment ?',
            'Spouse name',
            'Spouse first dose appointment date',
            'Spouse second dose appointment date',
            'Do you have children 18 years and above ?',
            'Created Date',
            'Updated Date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = Vaccine::get()->count() + 1;
                $cellRange = 'A1:AB'.$all.'';
                $head_title = 'A1:AB1';
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

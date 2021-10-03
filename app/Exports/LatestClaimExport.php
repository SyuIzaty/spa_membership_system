<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\TrainingClaim;
use Carbon\Carbon;
use Auth;
use DB;

class LatestClaimExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    public function __construct(String $year = null)
    {
        $this->year = $year;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $claim = TrainingClaim::where( DB::raw('YEAR(start_date)'), '=', $this->year )->get();
        
        return $claim;
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            isset($claim->start_date) ? date(' Y ', strtotime($claim->start_date) ) : '--',
            $claim->staffs->staff_id ?? '--',
            $claim->staffs->staff_name ?? '--',
            $claim->training_id ?? '--',
            $claim->title ?? '--',
            $claim->types->type_name ?? '--',
            $claim->categories->category_name ?? '--',
            isset($claim->start_date) ? date(' d/m/Y ', strtotime($claim->start_date) ) : '--',
            isset($claim->start_time) ? date(' h:i A ', strtotime($claim->start_time) ) : '--',
            isset($claim->end_date) ? date(' d/m/Y ', strtotime($claim->end_date) ) : '--',
            isset($claim->end_time) ? date(' h:i A ', strtotime($claim->end_time) ) : '--',
            $claim->venue ?? '--',
            $claim->link ?? '--',
            $claim->claim_hour ?? '--',
            $claim->claimStatus->status_name ?? '--',
            $claim->approved_hour ?? '--',
            $claim->reject_reason ?? '--',
            $claim->users->name ?? '--',
            isset($claim->created_at) ? date(' d/m/Y | h:i A', strtotime($claim->created_at) ) : '--'
        ];
    }

    public function headings(): array
    {
        return [
            '#ID',
            'YEAR',
            'STAFF ID',
            'STAFF NAME',
            'TRAINING ID',
            'TITLE',
            'TYPE',
            'CATEGORY',
            'START DATE',
            'START TIME',
            'END DATE',
            'END TIME',
            'VENUE',
            'LINK',
            'CLAIM HOUR',
            'STATUS',
            'APPROVED HOUR',
            'REJECT REASON',
            'ASSIGNED BY',
            'CREATED DATE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = TrainingClaim::get()->count() + 1;
                $cellRange = 'A1:T'.$all.'';
                $head_title = 'A1:T1';
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

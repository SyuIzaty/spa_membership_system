<?php

namespace App\Exports;

use App\Covid;
use App\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UnregisterCovidExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    use Exportable;
    public function __construct($date, $category)
    {
        $this->date = $date;
        $this->category = $category;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = collect(Covid::where('declare_date', $this->date)->pluck('user_id'))->toArray();
        $covid = User::whereNotIn('id',$data)->where('category',$this->category)->get(); 

        return $covid;
    }

    public function map($covid): array
    {
        return [
            isset($covid->id) ? $covid->id : '--',
            isset($covid->name) ? $covid->name : '--',
            isset($covid->email) ? $covid->email : '--',
            isset($covid->category) ? $covid->category : '--',
            isset($this->date) ? date(' Y-m-d ', strtotime($this->date)) : '--', 
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Position',
            'Request Date',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = User::get()->count() + 1;
                $cellRange = 'A1:E'.$all.'';
                $head_title = 'A1:E1';
                $event->sheet->getDelegate()->getStyle($head_title)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($head_title)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('80e5ff');
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

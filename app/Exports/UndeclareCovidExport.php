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

class UndeclareCovidExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    use Exportable;
    public function __construct(String $datek = null, String $cates = null)
    {
        $this->datek = $datek;
        $this->cates = $cates;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $datas = $datass =  '';
    
        if($this->datek && $this->cates)
        {
            $result = new User();

            if($this->datek != "" && $this->cates != "" )
            {
                $datas = Covid::select('user_id')->where('user_position',$this->cates)->where('declare_date', $this->datek)->distinct()->get();
                $result = User::where('category',$this->cates)->whereNotIn('id',$datas); 
            }

            $data = $result->get();
        }
        
        return collect($data);
    }

    public function map($data): array
    {
        return [
            isset($data->id) ? $data->id : '--',
            isset($data->name) ? $data->name : '--',
            isset($data->email) ? $data->email : '--',
            isset($data->category) ? $data->category : '--',
            isset($this->datek) ? date(' Y-m-d ', strtotime($this->datek)) : '--', 
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

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Stock;
use App\Staff;
use Auth;

class StockExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $stock = Stock::where('current_owner', Auth::user()->id)->get();

        return $stock;
    }

    public function map($stock): array
    {
        $total_bal = 0;
        foreach($stock->transaction as $list){
            $total_bal += ($list->stock_in - $list->stock_out);
        }

        if($total_bal <= 0) {
            $stat = 'OUT OF STOCK';
        } else {
            $stat = 'READY STOCK';
        }

        if($stock->status == '1') {
            $stats = 'ACTIVE';
        } else {
            $stats = 'INACTIVE';
        }


        return [
            $stock->id,
            $stock->departments->department_name,
            isset($stock->stock_code) ? $stock->stock_code : 'No Data',
            isset($stock->stock_name) ? $stock->stock_name : 'No Data',
            isset($stock->model) ? $stock->model : 'No Data',
            isset($stock->brand) ? $stock->brand : 'No Data',
            isset($total_bal) ? $total_bal : 'No Data',
            isset($stat) ? $stat : 'No Data',
            isset($stats) ? $stats : 'No Data',
            isset($stock->user->name) ? $stock->user->name : 'No Data',
            isset($stock->created_at) ? date(' d/m/Y | h:i:s A', strtotime($stock->created_at) ) : 'No Data'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'DEPARTMENT',
            'CODE',
            'NAME',
            'MODEL',
            'BRAND',
            'CURRENT BALANCE',
            'BALANCE STATUS',
            'STATUS',
            'CURRENT OWNER',
            'CREATED DATE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = Stock::get()->count() + 1;
                $cellRange = 'A1:K'.$all.'';
                $head_title = 'A1:K1';
                $event->sheet->getDelegate()->getStyle($head_title)->getFont()->setBold(true)->setName('Arial');
                $event->sheet->getDelegate()->getStyle($head_title)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffe1b7');
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

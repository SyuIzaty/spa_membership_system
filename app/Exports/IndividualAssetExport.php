<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Custodian;
use Auth;

class IndividualAssetExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $verify = Custodian::where('custodian_id', Auth::user()->id)->where('verification', '1')->where('status', '2')->get();

        return $verify;
    }

    public function map($verify): array
    {
        return [
            $verify->assets->id ?? '--',
            $verify->assets->codeType->code_name ?? '--',
            $verify->assets->finance_code ?? '--',
            $verify->assets->asset_code ?? '--',
            $verify->assets->asset_name ?? '--',
            $verify->assets->type->asset_type ?? '--',
            $verify->assets->serial_no ?? '--',
            $verify->assets->model ?? '--',
            $verify->assets->brand ?? '--',
            $verify->assets->assetStatus->status_name ?? '--',
            $verify->assets->inactive_date ?? '--',
            $verify->assets->availabilities->name ?? '--',
            $verify->assets->set_package ?? '--',
            $verify->assets->total_price ?? '--',
            $verify->assets->lo_no ?? '--',
            $verify->assets->do_no ?? '--',
            $verify->assets->io_no ?? '--',
            $verify->assets->purchase_date ?? '--',
            $verify->assets->vendor_name ?? '--',
            $verify->assets->remark ?? '--',
            $verify->assets->custodians->name ?? '--',
            $verify->assets->storage_location ?? '--',
            $verify->user->name ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($verify->created_at) ) ?? '--',
            date(' d/m/Y | h:i:s A', strtotime($verify->verification_date) ) ?? '--',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'CODE TYPE',
            'FINANCE_CODE',
            'ASSET_CODE',
            'ASSET_NAME',
            'ASSET_TYPE',
            'SERIAL_NO',
            'MODEL',
            'BRAND',
            'STATUS',
            'SELL/DISPOSE DATE',
            'AVAILABILITY',
            'SET',
            'PRICE',
            'LO_NO',
            'DO_NO',
            'IO_NO',
            'PURCHASE_DATE',
            'VENDOR',
            'REMARK',
            'CUSTODIAN',
            'LOCATION',
            'ASSIGNED_BY',
            'ASSIGNED_DATE',
            'VERIFICATION DATE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $all = Custodian::get()->count() + 1;
                $cellRange = 'A1:Y'.$all.'';
                $head_title = 'A1:Y1';
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

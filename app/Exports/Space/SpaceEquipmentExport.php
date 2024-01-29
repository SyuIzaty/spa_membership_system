<?php

namespace App\Exports\Space;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\SpaceCategory;
use App\SpaceRoom;
use App\SpaceItem;
use App\SpaceBlock;
use App\AssetType;

class SpaceEquipmentExport implements FromView, WithStyles, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($block_id, $status_id, $room_type)
    {
        $this->block_id = $block_id;
        $this->status_id = $status_id;
        $this->room_type = $room_type;
    }

    public function view(): View
    {
        $category = SpaceCategory::all();
        $type = AssetType::all();
        $cond = "1";

        $data = $this->filterData($this->block_id,$this->room_type,$this->status_id);

        $room = SpaceRoom::whereRaw($data)->get();
        return view('space.space-setting.report.export', compact('category','type','room'));
    }

    public function filterData($block_id,$room_type,$status_id)
    {
        $cond = "1";
        if($block_id && $block_id != "All")
        {
            $cond .= " AND (block_id = '".$block_id."')";
        }
        if($room_type && $room_type != "All")
        {
            $cond .= " AND (room_id = '".$room_type."')";
        }
        if($status_id && $status_id != "All")
        {
            $cond .= " AND (status_id = '".$status_id."')";
        }

        return $cond;
    }

    public function styles(Worksheet $sheet)
    {
        $data = $this->filterData($this->block_id,$this->room_type,$this->status_id);
        $total = SpaceRoom::whereRaw($data)->count()+5;
        $category = SpaceCategory::count();
        $type = AssetType::count();
        $all_item = (($category + $type) * 3) + 5;

        $cell = "A";
        for($i=1;$i<$all_item;$i++){

            ++$cell;

        }

        return [
            "A1:{$cell}{$total}" => [
                // 'borders' => ['allBorders' => [
                //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //     ]
                // ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        $data = $this->filterData($this->block_id,$this->room_type,$this->status_id);
        $total = SpaceRoom::whereRaw($data)->count()+5;
        $category = SpaceCategory::count();
        $type = AssetType::count();
        $all_item = (($category + $type) * 3) + 5;

        $cell = "A";
        for($i=1;$i<$all_item;$i++){
            ++$cell;
        }

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellAllRange = 'A1:'.$cell.''.''.$total.'';
                $event->sheet->getDelegate()->getStyle('A1:'.$cell.''.''.$total.'')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A2:'.$cell.''.''.$total.'')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setName('Arial');
                $event->sheet->getDelegate()->getStyle($cellAllRange)->getFont()->setSize('8');
                $event->sheet->getDelegate()->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }
}

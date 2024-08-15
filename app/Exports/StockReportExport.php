<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Stock;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class StockReportExport implements FromView, WithColumnFormatting
{
    protected $department;
    protected $stock;
    protected $owner;
    protected $total;

    public function __construct($department, $stock, $owner)
    {
        $this->department = $department;
        $this->stock = (array)$stock;
        $this->owner = $owner;
    }

    public function view(): View
    {
        $department = $this->department;

        $stock = (array)$this->stock;

        $owner = $this->owner;

        $data = Stock::query();

        if (!empty($department) && $stock == 'null' && $owner == 'null') {

            $data->where('department_id', $department);

        } elseif (!empty($department) && !empty($stock) && $owner == 'null') {

            $stockArray = explode(',', $stock[0]);

            $data->where('department_id', $department)->whereIn('id', $stockArray);

        } elseif (!empty($department) && $stock == 'null' && !empty($owner)) {

            // $data->where('department_id', $department)->where('current_owner', $owner);
            $data->where('department_id', $department)
                ->where(function($query) use ($owner) {
                    $query->where('current_owner', $owner)
                        ->orWhere('current_co_owner', $owner);
                });

        } elseif (!empty($department) && !empty($stock) && !empty($owner)) {

            $stockArray = explode(',', $stock[0]);

            // $data->where('department_id', $department)->whereIn('id', $stockArray)->where('current_owner', $owner);
            $data->where('department_id', $department)
                ->whereIn('id', $stockArray)
                ->where(function($query) use ($owner) {
                    $query->where('current_owner', $owner)
                        ->orWhere('current_co_owner', $owner);
                });

        } else {

            $data = $data->where('id', '<', 0);
        }

        $data = $data->get();

        return view('inventory.stock.stock-report-export', compact('data'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

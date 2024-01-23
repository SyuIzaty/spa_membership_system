<?php

namespace App\Exports;

use App\Rental;
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

class RentalReportExport implements FromView, WithColumnFormatting
{
    protected $department;
    protected $asset;
    protected $renter;

    public function __construct($department, $asset, $renter)
    {
        $this->department = $department;
        $this->asset = (array)$asset;
        $this->renter = $renter;
    }

    public function view(): View
    {
        $department = $this->department;

        $asset = (array)$this->asset;

        $renter = $this->renter;

        $data = Rental::query();

        if ($department== 'null' && count(array_filter($asset, function ($value) {
                return $value !== 'null';
            })) == 0 && $renter== 'null') {

            $data;

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
                return $value !== 'null';
            })) == 0 && $renter== 'null') {

            $data->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            });

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
                return $value !== 'null';
            })) != 0 && $renter== 'null') {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->whereIn('asset_id', $assetArray);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
                return $value !== 'null';
            })) == 0 && !empty($renter)) {

            $data->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->where('staff_id', $renter);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
                return $value !== 'null';
            })) != 0 && !empty($type) && !empty($renter)) {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('asset', function($q) use($department){
                $q->whereHas('type', function($q) use($department){
                    $q->where('department_id', $department);
                });
            })->whereIn('asset_id', $assetArray)->where('staff_id', $renter);

        } else {

            $data = $data->where('id', '<', 0);
        }

        $data = $data->get();

        return view('inventory.rental.rental-report-export', compact('data'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

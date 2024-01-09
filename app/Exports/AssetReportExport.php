<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Asset;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class AssetReportExport implements FromView, WithColumnFormatting
{
    protected $department;
    protected $asset;
    protected $type;
    protected $custodian;

    public function __construct($department, $asset, $type, $custodian)
    {
        $this->department = $department;
        $this->asset = (array)$asset;
        $this->type = $type;
        $this->custodian = $custodian;
    }

    public function view(): View
    {
        $department = $this->department;

        $asset = (array)$this->asset;

        $type = $this->type;

        $custodian = $this->custodian;

        $data = Asset::query();

        // $condAsset = count(array_filter($asset, function ($value) {
        //     return $value !== 'null';
        // })) == 0;

        if ($department== 'null' && count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) == 0 && $type== 'null' && $custodian== 'null') {

            $data;

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) == 0 && $type== 'null' && $custodian== 'null') {

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            });

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) != 0 && $type== 'null' && $custodian== 'null') {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $assetArray);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) == 0 && !empty($type) && $custodian== 'null') {

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('asset_type', $type);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) == 0 && $type== 'null' && !empty($custodian)) {

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('custodian_id', $custodian);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) != 0 && !empty($type) && $custodian== 'null') {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $assetArray)->where('asset_type', $type);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) != 0 && $type== 'null' && !empty($custodian)) {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $assetArray)->where('custodian_id', $custodian);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) == 0 && !empty($type) && !empty($custodian)) {

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->where('asset_type', $type)->where('custodian_id', $custodian);

        } elseif ($department != 'null'&& count(array_filter($asset, function ($value) {
            return $value !== 'null';
        })) != 0 && !empty($type) && !empty($custodian)) {

            $assetArray = explode(',', $asset[0]);

            $data->whereHas('type', function($q) use($department){
                $q->where('department_id', $department);
            })->whereIn('id', $assetArray)->where('asset_type', $type)->where('custodian_id', $custodian);

        } else {

            $data = $data->where('id', '<', 0);
        }

        $data = $data->get();

        return view('inventory.asset.asset-report-export', compact('data'));
    }

    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

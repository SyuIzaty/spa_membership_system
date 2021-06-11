<?php

namespace App\Exports;

use App\Asset;
use App\AssetType;
use App\AssetDepartment;
use App\Custodian;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class AssetExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $department = null , String $status = null, String $type = null)
    {
        $this->department = $department;
        $this->status = $status;
        $this->type = $type;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->department && $this->department != "All")
        {
            $cond .= " AND asset_type = '".$this->department."' ";
        }

        if($this->status && $this->status != "All")
        {
            $cond .= " AND status = '".$this->status."' ";
        }

        if($this->type && $this->type != "All")
        {
            $cond .= " AND asset_type = '".$this->type."' ";
        }

        $list =  Asset::whereRaw($cond)
        ->join('inv_asset_type','inv_asset_type.id','=','inv_asset.asset_type')
        ->join('status','inv_status.id','=','inv_asset.status')
        ->get();

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'ID'               => "",
                'Asset_code'       => "",
                'Asset_name'       => "",
                'Asset_type'       => "",
                'Serial_no'        => "",
                'Model'            => "",
                'Brand'            => "",
                'Price'            => "",
                'lo_no'            => "",
                'do_no'            => "",
                'io_no'            => "",
                'Purchase_date'    => "",
                'Vendor'           => "",
                'Custodian'        => "",
                'Location'         => "",
                'Created_by'       => "",
                'Remark'           => "",
                'Status'           => "",
                'Barcode'          => "",
                'Qrcode'           => "",
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['ID'] =$ivalue->user_id;
                    $data['Asset_code'] =$ivalue->asset_code;
                    $data['Asset_name'] =$ivalue->asset_name;
                    $data['Asset_type'] =$ivalue->asset_type;
                    $data['Serial_no'] =$ivalue->serial_no;
                    $data['Model'] =$ivalue->model;
                    $data['Brand'] =$ivalue->brand;
                    $data['Price'] =$ivalue->total_price;
                    $data['lo_no'] =$ivalue->lo_no;
                    $data['do_no'] =$ivalue->do_no;
                    $data['io_no'] =$ivalue->io_no;
                    $data['Purchase_date'] =$ivalue->purchase_date;
                    $data['Vendor'] =$ivalue->vendor_name;
                    $data['Custodian'] =$ivalue->custodian_id;
                    $data['Location'] =$ivalue->storage_location;
                    $data['Created_by'] =$ivalue->created_by;
                    $data['Remark'] =$ivalue->remark;
                    $data['Status'] =$ivalue->status;
                    $data['Barcode'] =$ivalue->barcode;
                    $data['Qrcode'] =$ivalue->qrcode;
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['ID','ASSET CODE','ASSET NAME','ASSET TYPE','SERIAL NO.', 'MODEL', 'BRAND','PRICE (RM)','L.O. NO.','D.D. NO.','INVOICE NO.','PURCHASE DATE','VENDOR','CUSTODIAN','LOCATION','CREATED BY','REMARK','STATUS', 'BARCODE', 'QRCODE'];
    }
}

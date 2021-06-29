<?php

namespace App\Exports;

use Auth;
use App\Asset;
use App\AssetType;
use App\AssetDepartment;
use App\Custodian;
use App\AssetAvailability;
use App\AssetCustodian;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class AssetExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $department = null , String $availability = null, String $type = null, String $status = null)
    {
        $this->department = $department;
        $this->availability = $availability;
        $this->type = $type;
        $this->status = $status;
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

        if($this->availability && $this->availability != "All")
        {
            $cond .= " AND availability = '".$this->availability."' ";
        }

        if($this->type && $this->type != "All")
        {
            $cond .= " AND asset_type = '".$this->type."' ";
        }

        if($this->status && $this->status != "All")
        {
            $cond .= " AND status = '".$this->status."' ";
        }

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $list = Asset::whereRaw($cond)->get();
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');

            $list = Asset::whereHas('type',function($q) use ($as){
                $q->whereHas('department', function($q) use ($as){
                    $q->whereIn('id', $as);
                });
            })->whereRaw($cond)->get();
        }

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'ID'               => "",
                'Finance_code'     => "",
                'Asset_code'       => "",
                'Asset_name'       => "",
                'Asset_type'       => "",
                'Serial_no'        => "",
                'Model'            => "",
                'Brand'            => "",
                'Status'           => "",
                'Availability'     => "",
                'Set'              => "",
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
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['ID'] =$ivalue->user_id;
                    $data['Finance_code'] =$ivalue->finance_code;
                    $data['Asset_code'] =$ivalue->asset_code;
                    $data['Asset_name'] =$ivalue->asset_name;
                    $data['Asset_type'] =$ivalue->asset_type;
                    $data['Serial_no'] =$ivalue->serial_no;
                    $data['Model'] =$ivalue->model;
                    $data['Brand'] =$ivalue->brand;
                    $data['Status'] =$ivalue->status;
                    $data['Availability'] =$ivalue->availability;
                    $data['Set'] =$ivalue->set_package;
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
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['ID','FINANCE CODE','ASSET CODE','ASSET NAME','ASSET TYPE','SERIAL NO.', 'MODEL', 'BRAND','STATUS', 'AVAILABILITY', 'SET','PRICE (RM)','L.O. NO.','D.O. NO.','INVOICE NO.','PURCHASE DATE','VENDOR','CUSTODIAN','LOCATION','CREATED BY','REMARK'];
    }
}

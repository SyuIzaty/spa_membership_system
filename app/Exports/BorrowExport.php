<?php

namespace App\Exports;

use App\Borrow;
use App\BorrowStatus;
use App\AssetCustodian;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;
use Auth;

class BorrowExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $asset = null , String $borrower = null, String $status = null)
    {
        $this->asset = $asset;
        $this->borrower = $borrower;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->asset && $this->asset != "All")
        {
            $cond .= " AND asset_id = '".$this->asset."' ";
        }

        if($this->borrower && $this->borrower != "All")
        {
            $cond .= " AND borrower_id = '".$this->borrower."' ";
        }

        if($this->status && $this->status != "All")
        {
            $cond .= " AND status = '".$this->status."' ";
        }

        if( Auth::user()->hasRole('Inventory Admin') )
        { 
            $list = Borrow::whereRaw($cond);
        }
        else
        {
            $as = AssetCustodian::where('custodian_id', Auth::user()->id)->pluck('department_id');
            
            $list = Borrow::whereHas('asset', function($q) use ($as){
                $q->whereHas('type',function($q) use ($as){
                    $q->whereHas('department', function($q) use ($as){
                        $q->whereIn('id', $as);
                    });
                });
            })->whereRaw($cond);
        }

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'ID'          => "",
                'Borrower'     => "",
                'Asset_type'  => "",
                'Asset_code'  => "",
                'Asset_name'  => "",
                'Reason'      => "",
                'Borrow_date' => "",
                'Return_date' => "",
                'Actual_date' => "",
                'Verified_by' => "",
                'Remark'      => "",
                'Status'      => "",
                'Created_by'  => "",
                'Created_at'  => "",
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['ID'] =$ivalue->id;
                    $data['Borrower'] =$ivalue->borrower_id;
                    $data['Asset_type'] =$ivalue->asset->type->asset_type;
                    $data['Asset_code'] =$ivalue->asset->asset_code;
                    $data['Asset_name'] =$ivalue->asset->asset_name;
                    $data['Reason'] =$ivalue->reason;
                    $data['Borrow_date'] =$ivalue->borrow_date;
                    $data['Return_date'] =$ivalue->return_date;
                    $data['Actual_date'] =$ivalue->actual_return_date;
                    $data['Verified_by'] =$ivalue->verified_by;
                    $data['Remark'] =$ivalue->remark;
                    $data['Status'] =$ivalue->status;
                    $data['Created_by'] =$ivalue->created_by;
                    $data['Created_at'] =$ivalue->created_at;
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['ID','BORROWER','ASSET TYPE','ASSET CODE','ASSET NAME','REASON', 'BORROW DATE', 'RETURN DATE','ACTUAL RETURN DATE', 'VERIFIED BY', 'REMARK','STATUS','CREATED BY','CREATED AT'];
    }
}
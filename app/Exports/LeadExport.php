<?php

namespace App\Exports;

use App\Lead;
use App\LeadGroup;
use App\LeadStatus;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class LeadExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $group = null ,  String $status = null)
    {
        $this->group = $group;
        $this->status = $status;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->group && $this->group != "All")
        {
            $cond .= " AND leads_group = ".$this->group;
        }

        if($this->status && $this->status != "All")
        {
            $cond .= " AND leads_status = '".$this->status."' ";
        }

        $list =  Lead::whereRaw($cond)
        ->join('leads_status','leads_status.id','=','leads.leads_status')
        ->join('leads_group','leads_group.id','=','leads.leads_group')
        ->get();

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'Name' => "",
                'IC' => "",
                'Email' => "",
                'Phone' => "",
                'Group' => "",
                'Status' => "",
                'Assigned_to' => "",
                'Created_at' => "",
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['Name'] =$ivalue->leads_name;
                    $data['IC'] =$ivalue->leads_ic;
                    $data['Email'] =$ivalue->leads_email;
                    $data['Phone'] =$ivalue->leads_phone;
                    $data['Group'] =$ivalue->leads_group;
                    $data['Status'] =$ivalue->leads_status;
                    $data['Assigned_to'] =$ivalue->assigned_to;
                    $data['Created_at'] =$ivalue->created_at;
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['LEAD NAME','LEAD IC','EMAIL','PHONE NUMBER','GROUP','STATUS','ASSIGNED TO','CREATED AT'];
    }

}

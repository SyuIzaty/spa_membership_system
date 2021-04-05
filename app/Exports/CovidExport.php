<?php

namespace App\Exports;

use App\Covid;
use App\UserType;
use App\Department;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;


class CovidExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct(String $name = null , String $category = null , String $position = null , String $department = null)
    {
        $this->name = $name;
        $this->category = $category;
        $this->position = $position;
        $this->department = $department;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $cond = "1";

        if($this->name && $this->name != "All")
        {
            $cond .= " AND user_name = ".$this->name;
        }

        if($this->category && $this->category != "All")
        {
            $cond .= " AND category = '".$this->category."' ";
        }

        if($this->position && $this->position != "All")
        {
            $cond .= " AND user_position = ".$this->position;
        }

        if($this->department && $this->department != "All")
        {
            $cond .= " AND department_id = '".$this->department."' ";
        }

        $list =  Covid::whereRaw($cond)
        ->join('user_position','cdd_user_types.user_code','=','cdd_covid_declarations.user_position')
        ->join('department_id','cdd_department.id','=','cdd_covid_declarations.department_id')
        ->get();

        $collected1 = collect($list)->groupBy('id')->toarray();

        $collected = collect($list)->groupBy('id')->transform(function($item,$key){
            $data = [
                'ID'            => "",
                'Name'          => "",
                'IC'            => "",
                'Email'         => "",
                'Phone'         => "",
                'Q1'            => "",
                'Q2'            => "",
                'Q3'            => "",
                'Q4a'           => "",
                'Q4b'           => "",
                'Q4c'           => "",
                'Q4d'           => "",
                'Category'      => "",
                'Position'      => "",
                'Department'    => "",
                'Form_type'     => "",
                'Declare_date'  => "",
                'Created_at'    => "",
            ];
            foreach($item as $ikey => $ivalue)
            {
                if($ikey == 0)
                {
                    $data['ID'] =$ivalue->user_id;
                    $data['Name'] =$ivalue->user_name;
                    $data['IC'] =$ivalue->user_ic;
                    $data['Email'] =$ivalue->user_email;
                    $data['Phone'] =$ivalue->user_phone;
                    $data['Q1'] =$ivalue->q1;
                    $data['Q2'] =$ivalue->q2;
                    $data['Q3'] =$ivalue->q3;
                    $data['Q4a'] =$ivalue->q4a;
                    $data['Q4b'] =$ivalue->q4b;
                    $data['Q4c'] =$ivalue->q4c;
                    $data['Q4d'] =$ivalue->q4d;
                    $data['Category'] =$ivalue->category;
                    $data['Position'] =$ivalue->user_position;
                    $data['Department'] =$ivalue->department_id;
                    $data['Form_type'] =$ivalue->form_type;
                    $data['Declare_date'] =$ivalue->declare_date;
                    $data['Created_at'] =$ivalue->created_at;
                }

            }
            return $data;
        });

        return $collected;
    }

    public function headings(): array
    {
        return ['ID','NAME','IC/PASSPORT NO','EMAIL','PHONE NUMBER', 'Q1', 'Q2','Q3','Q4A','Q4B','Q4C','Q4D','CATEGORY','POSITION','DEPARTMENT','FORM TYPE', 'DECLARE DATE', 'CREATED AT'];
    }
}

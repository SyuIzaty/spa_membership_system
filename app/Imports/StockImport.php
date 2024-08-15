<?php

namespace App\Imports;

use Auth;
use App\Files;
use App\Stock;
use Session;
use Carbon\Carbon;
use App\StockTransaction;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;

class StockImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
        return [
            'stock_code'       => 'nullable',
            'stock_name'       => 'required',
            'model'            => 'required',
            'brand'            => 'nullable',
            'status'           => 'required',
            'created_by'       => 'required',
            'department_id'    => 'required',
            'stock_id'         => 'nullable',
            'stock_in'         => 'required',
            'lo_no'            => 'nullable',
            'io_no'            => 'nullable',
            'unit_price'       => 'nullable',
            'purchase_date'    => 'nullable',
            'trans_date'       => 'nullable',
            'remark'           => 'nullable',
        ];
    }

    public function model(array $row)
    {
            $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

            $stock = Stock::create([
                'stock_code'                => $code,
                'stock_name'                => $row['stock_name'],
                'model'                     => $row['model'],
                'brand'                     => $row['brand'],
                'status'                    => $row['status'],
                'department_id'             => $row['department_id'],
                'created_by'                => $row['created_by'],
                'updated_by'                => $row['created_by'],
                'current_owner'             => $row['created_by'],
            ]);

            $transaction = StockTransaction::create([
                'stock_id'                => $stock->id,
                'stock_in'                => $row['stock_in'],
                'stock_out'               => '0',
                'lo_no'                   => $row['lo_no'],
                'io_no'                   => $row['io_no'],
                'unit_price'              => $row['unit_price'],
                'purchase_date'           => $row['purchase_date'] ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['purchase_date']) : null,
                'trans_date'              => Carbon::now()->toDateString(),
                'remark'                  => $row['remark'],
                'status'                  => '1',
                'created_by'              => $row['created_by'],
            ]);

            Session::flash('message', 'Stock and Transaction In Data Imported Successfully');
    }
}

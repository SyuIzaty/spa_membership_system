<?php

namespace App\Imports\Space;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\SpaceItem;

class SpaceUploadImport implements ToModel, WithValidation, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if(isset($row[1])){
            SpaceItem::updateOrCreate([
                'room_id' => isset($row[1]) ? $row[1] : NULL,
                'item_category' => isset($row[1]) ? 3 : NULL,
                'item_id' => isset($row[2]) ? $row[2] : NULL,
            ],[
                'quantity' => isset($row[3]) ? $row[3] : NULL,
                'name' => isset($row[4]) ? $row[4] : NULL,
                'serial_no' => isset($row[5]) ? $row[5] : NULL,
                'description' => isset($row[6]) ? $row[6] : NULL,
                'status' => 1,
            ]);
        }
    }


    public function startRow(): int
    {
        return 3;
    }

    public function rules(): array
    {
        return [
        ];
    }
}
